import _ from 'lodash'

export default {

	methods: {

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

        allActions: function() {

            // Determine the resource actions
            let resourceActions = this.actions;

            // Flag each resource action as a non-pivot action
            _.each(resourceActions, function(action) {
                action.isPivotAction = false;
            });

            // Determine the pivot actions
            let pivotActions = this.pivotActions != null
                ? this.pivotActions.actions
                : [];

            // Flag each pivot action as a pivot action
            _.each(pivotActions, function(action) {
                action.isPivotAction = true;
            });

            // Merge the two action lists together
            let actions = resourceActions.concat(pivotActions);

            // Order the actions based on the action priority
            return this.orderActionsByPriority(actions);

        },

        /**
         * Determine if the resource has any pivot actions available.
         */
        hasPivotActions() {
            return this.pivotActions && this.pivotActions.actions.length > 0
        },

        /**
         * Determine if the resource has any actions available.
         */
        actionsAreAvailable() {
            return this.allActions.length > 0
        },

        /**
         * Get the name of the pivot model for the resource.
         */
        pivotName() {
            return this.pivotActions ? this.pivotActions.name : ''
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
         * Get all of the available pivot actions for the resource.
         */
        availablePivotActions() {
            return _(this.pivotActions ? this.pivotActions.actions : [])
                .filter(action => {
                    if (this.selectedResources != 'all') {
                        return true
                    }

                    return action.availableForEntireResource
                })
                .value()
        },

	}

}