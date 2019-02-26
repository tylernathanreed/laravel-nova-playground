<template>
    <div>
        <dropdown class="bg-30 hover:bg-40 mr-3 rounded" v-if="actions.length > 0 || availablePivotActions.length > 0">
            <dropdown-trigger
                class="px-3 border rounded"
                :class="{
                    'bg-30 hover:bg-40 border-50 hover:border-60': !active,
                    'bg-primary border-primary': active
                }"
                slot-scope="{toggle}"
                :handle-click="toggle"
                :active="active"
            >
                <icon
                    type="actions-gearbox"
                    :class="{
                        'text-80': !active,
                        'text-white': active
                    }"
                />

                <span
                    v-if="!resource"
                    class="ml-2 font-bold"
                    :class="{
                        'text-80': !active,
                        'text-white': active
                    }"
                >
                    {{ selectedResourceCount }}
                </span>
            </dropdown-trigger>

            <dropdown-menu slot="menu" width="200" direction="rtl">
                <div class="text-left">

                    <component
                        v-for="(action, index) in allActions"
                        :key="`resource-action-0-${index}`"
                        :depth="0"
                        :is="action.actions ? 'action-group' : 'action-item'"
                        :selected-resources="selectedResources"
                        :resource="resource"
                        :resource-name="resourceName"
                        :pivot-name="pivotActions.name"
                        :action="action"
                        :relationship-type="relationshipType"
                        :via-relationship="queryString.viaRelationship"
                        :via-resource="queryString.viaResource"
                        :via-resource-id="queryString.viaResourceId"
                        :via-many-to-many="viaManyToMany"
                        @onActionSelected="onActionSelected"
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
import { InteractsWithResourceInformation } from 'laravel-nova'
import { HasActions, InteractsWithResourceActions } from '../mixins/mixins'

export default {
    mixins: [HasActions, InteractsWithResourceInformation, InteractsWithResourceActions],

    props: {
        active: {
            type: Boolean,
            default: false
        },
        selectedResources: {
            type: [Array, String],
            default: () => [],
        },
        resource: Object,
        resourceName: String,
        actions: {},
        pivotActions: {},
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

    watch: {
        /**
         * Watch the actions property for changes.
         */
        actions() {
            this.initializeActionFields()
        },

        /**
         * Watch the pivot actions property for changes.
         */
        pivotActions() {
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
         * Propagates the action selected event.
         *
         * @param  {Object}   action
         * @param  {boolean}  isPivotAction
         *
         * @return void
         */
        onActionSelected: function(action, isPivotAction) {
            this.openConfirmationModal(action, isPivotAction);
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

        /**
         * Determine if the current resource listing is via a many-to-many relationship.
         */
        viaManyToMany() {
            return (
                this.relationshipType == 'belongsToMany' || this.relationshipType == 'morphToMany'
            )
        },

        /**
         * Returns the humanized number of selected resources.
         */
        selectedResourceCount() {
            if(this.selectedResources == 'all') {
                return 'All'
            }

            return this.selectedResources.length
        }

    },
}
</script>
