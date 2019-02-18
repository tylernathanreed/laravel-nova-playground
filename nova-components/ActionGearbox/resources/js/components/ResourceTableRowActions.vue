<template>
    <div>
        <dropdown class="bg-30 hover:bg-40 mr-3 rounded" v-if="this.hasAnyAuthorizations() && actions.length > 0">
            <dropdown-trigger class="px-3" slot-scope="{toggle}" :handle-click="toggle">
                <icon type="actions-gearbox" class="text-80" />
            </dropdown-trigger>

            <dropdown-menu slot="menu" width="200" direction="rtl">
                <div class="text-left">

                    <component
                        v-for="(action, index) in actions"
                        :key="`resource-action-0-${index}`"
                        :depth="0"
                        :is="action.actions ? 'action-group' : 'action-item'"
                        :testId="testId"
                        :resource="resource"
                        :resource-name="resourceName"
                        :pivot-name="resourcePivotActions.name"
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
import { InteractsWithResourceActions } from '../mixins/mixins'

export default {
    mixins: [InteractsWithResourceInformation, InteractsWithResourceActions],

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

        },

        /**
         * Orders the specified actions by the given priority map.
         *
         * @param  {Array}       actions
         * @param  {Array|null}  priorityMap
         *
         * @return {Array}
         */
        orderActionsByPriority(actions, priorityMap = null) {

            // If a priority map was not provided, use the default priority
            if(priorityMap === null) {
                priorityMap = Nova.config.actionPriority;
            }

            // Initialize the the last index
            let lastIndex = 0;

            // Initialize the last priority index
            let lastPriorityIndex = undefined;

            // Iterate through the actions
            for(var index = 0; index < actions.length; index++) {

                // Determine the current action
                let action = actions[index];

                // Determine the action index within the priority map
                let priorityIndex = priorityMap.indexOf(action.class);

                // If the action is not listed in the priority map, skip it
                if(priorityIndex == -1) {
                    continue;
                }

                // This action is in the priority map. If we have encountered another action
                // that was also in the priority map, but it was at a lower priority, then
                // we will move this action to be above the previously encountered one.

                // Check if we've previously encountered an action lower in the priority map
                if(lastPriorityIndex !== undefined && priorityIndex < lastPriorityIndex) {

                    // Move the action action above the previously encountered action, then resort
                    return this.orderActionsByPriority(
                        _.tap(actions, () => actions.splice(lastIndex, 0, actions.splice(index, 1)[0])),
                    priorityMap);

                }

                // This action is in the priority map; but, this is the first action we have
                // encountered from the map thus far. We'll save its current index and its
                // index from the priority map, so we can compare against them later on.

                // Remember the last index and last priority index
                lastIndex = index;
                lastPriorityIndex = priorityIndex;

            }

            // Return the sorted actions
            return actions;

        }

    },

    computed: {

        actions: function() {

            // Determine the resource actions
            let resourceActions = this.resourceActions;

            // Flag each resource action as a non-pivot action
            _.each(resourceActions, function(action) {
                action.isPivotAction = false;
            });

            // Determine the pivot actions
            let pivotActions = this.resourcePivotActions.actions;

            // Flag each pivot action as a pivot action
            _.each(pivotActions, function(action) {
                action.isPivotAction = true;
            });

            // Merge the two action lists together
            let actions = resourceActions.concat(pivotActions);

            // Order the actions based on the action priority
            return this.orderActionsByPriority(actions);

        }

    }

}
</script>