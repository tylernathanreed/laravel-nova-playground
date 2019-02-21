export default {

	methods: {

        /**
         * Confirm with the user that they actually want to run the selected action.
         *
         * @param  {Object}   action  The selected action.
         * @param  {boolean}  pivot   Whether or not the action is a pivot action.
         *
         * @return {void}
         */
        openConfirmationModal(action, pivot = false) {

            this.selectedAction = action;
            this.selectedActionIsPivotAction = pivot;
            this.confirmActionModalOpened = true;

        },

        /**
         * Close the action confirmation modal.
         */
        closeConfirmationModal() {
            this.confirmActionModalOpened = false;
        },

        /**
         * Execute the selected action.
         */
        executeAction() {

            // Set this action as working
            this.working = true;

            if(!this.resource && this.selectedResources.length == 0) {
                alert(this.__('Please select a resource to perform this action on.'))
                return;
            }

            window['request'] = {
                method: 'post',
                url: this.actionRequestUrl,
                params: this.actionRequestQueryString,
                data: this.actionFormData(),
            };

            // Submit the request
            Nova.request(window['request'])

                // Handle the response
                .then(response => {
                    this.handleActionResponse(response.data);
                })

                // Catch any errors
                .catch(error => {

                    this.working = false;

                    if(error.response.status == 422) {
                        this.errors = new Errors(error.response.data.errors)
                    }

                })

        },

        /**
         * Gather the action FormData for the given action.
         *
         * @return {FormData}
         */
        actionFormData() {

            return _.tap(new FormData(), formData => {

                formData.append('resources', this.selectedResources || [this.resource.id.value]);

                _.each(this.selectedAction.fields, field => {
                    field.fill(formData)
                });

            });

        },

        /**
         * Handle the action response. Typically either a message, download or a redirect.
         *
         * @param  {object}  response
         *
         * @return {void}
         */
        handleActionResponse(response) {

            // Close the action modal, unless we're making another request
            if(!response.request) {
                this.confirmActionModalOpened = false;
            }

            // Check for a message
            if(response.message) {
                this.$emit('actionExecuted');
                this.$toasted.show(response.message, { type: 'success' });
            }

            // Check if the response was deleted
            else if(response.deleted) {
                this.$emit('actionExecuted')
            }

            // Check for a danger response
            else if(response.danger) {
                this.$emit('actionExecuted')
                this.$toasted.show(response.danger, { type: 'error' })
            }

            // Check for a download response
            else if(response.download) {
                let link = document.createElement('a')
                link.href = response.download
                link.download = response.name
                link.click()
            }

            // Check for a request
            else if(response.request) {

                // Submit the request
                Nova.request(response.request).then(response => {
                    this.handleActionResponse(response.data);
                });

            }

            // Check for a redirect response
            else if(response.redirect) {
                window.location = response.redirect
            }

            // Assume the action was successful
            else {

                // Fire the action executed event
                this.$emit('actionExecuted');

                // Display that the action run successfully
                this.$toasted.show(this.__('The action ran successfully!'), { type: 'success' });

                // To avoid having to override every Vue component between
                // this one and the index, we're just going to directly
                // call the action executed response from the index.

                // Update the index resources
                if(this.resource) {
                    this.updateIndexResources();
                }

            }

            // Stop working, unless we're making another request
            if(!response.request) {
                this.working = false;
            }

        },

        /**
         * Updates the index resources.
         *
         * @return {void}
         */
        updateIndexResources() {

            // Determine the resource index
            var index = this.getResourceIndex();

            // Stop if we couldn't find the resource index
            if(index == null) {
                return;
            }

            // Call the resource updater
            index.getResources();

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

        allActions: function() {

            // Determine the resource actions
            let resourceActions = this.actions;

            // Flag each resource action as a non-pivot action
            _.each(resourceActions, function(action) {
                action.isPivotAction = false;
            });

            // Determine the pivot actions
            let pivotActions = this.pivotActions.actions;

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
         * Returns the url to submit the action request to.
         *
         * @return {string}
         */
        actionRequestUrl() {

            // Check for a custom endpoint
            if(this.selectedAction.endpoint) {

                // Determine the custom endpoint
                let endpoint = this.selectedAction.endpoint;

                // Replace the resource name, if applicable
                endpoint = endpoint.replace(/\{\{resourceName\}\}/g, this.resourceName);

                // Return the custom endpoint
                return endpoint;

            }

            // Return the default implementation
            return this.endpoint || `/nova-api/${this.resourceName}/action`;
        },

        /**
         * Returns the query string for an action request.
         *
         * @return {Object}
         */
        actionRequestQueryString() {
            return {
                _method: this.selectedAction.method || 'post',
                action: this.selectedAction.uriKey,
                pivotAction: this.selectedActionIsPivotAction,
                search: this.queryString.currentSearch,
                filters: this.queryString.encodedFilters,
                trashed: this.queryString.currentTrashed,
                viaResource: this.queryString.viaResource,
                viaResourceId: this.queryString.viaResourceId,
                viaRelationship: this.queryString.viaRelationship,
            }
        }

	}

}
