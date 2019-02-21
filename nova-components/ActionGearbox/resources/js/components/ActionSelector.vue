<template>
    <div>
        <dropdown class="bg-30 hover:bg-40 mr-3 rounded" v-if="actions.length > 0 || availablePivotActions.length > 0">
            <dropdown-trigger class="px-3" slot-scope="{toggle}" :handle-click="toggle">
                <icon type="actions-gearbox" class="text-80" />
            </dropdown-trigger>

            <dropdown-menu slot="menu" width="200" direction="rtl">
                <div class="text-left">

                    <component
                        v-for="(action, index) in allActions"
                        :key="`resource-action-0-${index}`"
                        :depth="0"
                        :is="action.actions ? 'action-group' : 'action-item'"
                        :resource-name="resourceName"
                        :pivot-name="pivotActions.name"
                        :action="action"
                        :relationship-type="relationshipType"
                        :via-relationship="queryString.viaRelationship"
                        :via-resource="queryString.viaResource"
                        :via-resource-id="queryString.viaResourceId"
                        :via-many-to-many="viaManyToMany"
                        @onActionSelected="openConfirmationModal"
                    />

                </div>
            </dropdown-menu>
        </dropdown>

        <!-- Action Confirmation Modal -->
        <!-- <portal to="modals"> -->
        <transition name="fade">
            <component
                :is="selectedAction.component"
                :working="working"
                v-if="confirmActionModalOpened"
                :selected-resources="selectedResources"
                :resource-name="resourceName"
                :action="selectedAction"
                :errors="errors"
                @confirm="executeAction"
                @close="confirmActionModalOpened = false"
            />
        </transition>
        <!-- </portal> -->
    </div>
</template>

<script>
import _ from 'lodash'
import { Errors, InteractsWithResourceInformation } from 'laravel-nova'
import { InteractsWithResourceActions } from '../mixins/mixins'

export default {
    mixins: [InteractsWithResourceInformation, InteractsWithResourceActions],

    props: {
        selectedResources: {
            type: [Array, String],
            default: () => [],
        },
        resourceName: String,
        actions: {},
        pivotActions: {},
        pivotName: String,
        endpoint: {
            type: String,
            default: null,
        },
        relationshipType: {
            type: String,
            default: null,
        },
        queryString: {
            type: Object,
            default: () => ({
                currentSearch: '',
                encodedFilters: '',
                currentTrashed: '',
                viaResource: '',
                viaResourceId: '',
                viaRelationship: '',
            }),
        },
    },

    data: () => ({
        working: false,
        errors: new Errors(),
        selectedActionKey: '',
        confirmActionModalOpened: false,
    }),

    watch: {
        /**
         * Watch the actions property for changes.
         */
        actions() {
            this.selectedActionKey = ''
            this.initializeActionFields()
        },

        /**
         * Watch the pivot actions property for changes.
         */
        pivotActions() {
            this.selectedActionKey = ''
            this.initializeActionFields()
        },
    },

    methods: {
        /**
         * Determine whether the action should redirect or open a confirmation modal
         */
        determineActionStrategy() {
            if (this.selectedAction.withoutConfirmation) {
                this.executeAction()
            }

            this.openConfirmationModal()
        },

        /**
         * Confirm with the user that they actually want to run the selected action.
         */
        openConfirmationModal() {
            this.confirmActionModalOpened = true
        },

        /**
         * Close the action confirmation modal.
         */
        closeConfirmationModal() {
            this.confirmActionModalOpened = false
        },

        /**
         * Initialize all of the action fields to empty strings.
         */
        initializeActionFields() {
            _(this.allActions).each(action => {
                _(action.fields).each(field => {
                    field.fill = () => ''
                })
            })
        },

    },

    computed: {
        selectedAction() {
            if (this.selectedActionKey) {
                return _.find(this.allActions, a => a.uriKey == this.selectedActionKey)
            }
        },

        /**
         * Determine if the selected action is a pivot action.
         */
        selectedActionIsPivotAction() {
            return (
                this.hasPivotActions &&
                Boolean(_.find(this.pivotActions.actions, a => a === this.selectedAction))
            )
        },

        /**
         * Get all of the available non-pivot actions for the resource.
         */
        availableActions() {
            return _(this.actions)
                .filter(action => {
                    if (this.selectedResources != 'all') {
                        return true
                    }

                    return action.availableForEntireResource
                })
                .value()
        },

        /**
         * Determine whether there are any pivot actions
         */
        hasPivotActions() {
            return this.availablePivotActions.length > 0
        },

        /**
         * Get all of the available pivot actions for the resource.
         */
        availablePivotActions() {
            return _(this.pivotActions.actions)
                .filter(action => {
                    if (this.selectedResources != 'all') {
                        return true
                    }

                    return action.availableForEntireResource
                })
                .value()
        },

        /**
         * Determine if the current resource listing is via a many-to-many relationship.
         */
        viaManyToMany() {
            return (
                this.relationshipType == 'belongsToMany' || this.relationshipType == 'morphToMany'
            )
        },

    },
}
</script>
