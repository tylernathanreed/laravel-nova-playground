<template>
    <div>
        <dropdown class="bg-30 hover:bg-40 mr-3 rounded" v-if="this.hasAnyAuthorizations() && allActions.length > 0">
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
                        :testId="testId"
                        :resource="resource"
                        :resource-name="resourceName"
                        :pivot-name="pivotActions.name"
                        :action="action"
                        :relationship-type="relationshipType"
                        :via-relationship="viaRelationship"
                        :via-resource="viaResource"
                        :via-resource-id="viaResourceId"
                        :via-many-to-many="viaManyToMany"
                        @onActionSelected="openConfirmationModal"
                    />

                </div>
            </dropdown-menu>
        </dropdown>

        <div class="text-left">
            <transition name="fade">
                <confirm-action-modal
                    :working="working"
                    v-if="confirmActionModalOpened"
                    :selected-resources="[resource.id.value]"
                    :resource-name="resourceName"
                    :selected-action="selectedAction"
                    :errors="errors"
                    @confirm="executeAction"
                    @close="confirmActionModalOpened = false"
                />
            </transition>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import { Errors, InteractsWithResourceInformation } from 'laravel-nova'
import {
    InteractsWithResourceActions,
    ObtainsActionsFromParentComponent,
    ObtainsQueryStringFromRoute,
} from '../mixins/mixins'

export default {
    mixins: [
        InteractsWithResourceInformation,
        InteractsWithResourceActions,
        ObtainsActionsFromParentComponent,
        ObtainsQueryStringFromRoute
    ],

    props: [
        'testId',
        'deleteResource',
        'restoreResource',
        'resource',
        'resourcesSelected',
        'resourceName',
        'relationshipType',
        'viaRelationship',
        'viaResource',
        'viaResourceId',
        'viaManyToMany',
        'checked',
        'actionsAreAvailable',
        'shouldShowCheckboxes',
        'updateSelectionStatus',
        'endpoint'
    ],

    data: () => ({

        working: false,
        errors: new Errors(),
        selectedAction: null,
        selectedActionIsPivotAction: false,
        confirmActionModalOpened: false

    }),

    methods: {

        /**
         * Select the resource in the parent component
         */
        toggleSelection() {
            this.updateSelectionStatus(this.resource)
        },

        /**
         * Returns whether or not the authenticated user has authorization to perform at least one action.
         *
         * @return {boolean}
         */
        hasAnyAuthorizations() {

            return this.resource.authorizedToView
                || this.resource.authorizedToUpdate
                || (this.resource.authorizedToDelete && (! this.resource.softDeleted || this.viaManyToMany))
                || (this.resource.authorizedToRestore && this.resource.softDeleted && ! this.viaManyToMany);

        }

    }

}
</script>