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

                formData.append('resources', [this.resource.id.value]);

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
                this.updateIndexResources();

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
		 * Returns the closest resource index in the parent tree.
		 *
		 * @return {VueComponent|null}
		 */
		getResourceIndex() {

		    // Walk up the parent tree
		    for(let parent = this.$parent; typeof parent !== 'undefined'; parent = parent.$parent) {

		        // Return the eparent if it is a resource index
		        if(parent.$options.name === 'resource-index') {
		            return parent;
		        }

		    }

		    // Failed to find resource index
		    return null;

		},

		/**
		 * Returns the available resource actions.
		 *
		 * @return {Array}
		 */
		getResourceActions() {
		    return this.getResourceIndex().actions;
		},

		/**
		 * Returns the available resource pivot actions.
		 *
		 * @return {Array}
		 */
		getResourcePivotActions() {
		    return this.getResourceIndex().pivotActions;
		}

	},

	computed: {

	    /**
	     * Computed alias of {@see $this.getResourceActions()}.
	     *
	     * @return {Array}
	     */
	    resourceActions() {
	        return this.getResourceActions();
	    },

	    /**
	     * Computed alias of {@see $this.getResourcePivotActions()}.
	     *
	     * @return {Array}
	     */
	    resourcePivotActions() {
	        return this.getResourcePivotActions();
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
        },

        /**
         * Returns the query string for this page.
         *
         * @return {Object}
         */
        queryString() {

            return {
                currentSearch: this.currentSearch,
                encodedFilters: this.encodedFilters,
                currentTrashed: this.currentTrashed,
                viaResource: this.viaResource,
                viaResourceId: this.viaResourceId,
                viaRelationship: this.viaRelationship
            };

        },

        /**
         * Returns the current search value from the query string.
         *
         * @return {string}
         */
        currentSearch() {
            return this.$route.query[this.searchParameter] || '';
        },

        /**
         * Returns the encoded filters from the query string.
         *
         * @return {string}
         */
        encodedFilters() {
          return this.$route.query[this.filterParameter] || '';
        },

        /**
         * Returns the current trashed constraint value from the query string.
         *
         * @return {string}
         */
        currentTrashed() {
            return this.$route.query[this.trashedParameter] || '';
        },

        /**
         * Returns the name of the search query string variable.
         *
         * @return {string}
         */
        searchParameter() {
            return this.resourceName + '_search';
        },

        /**
         * Returns the name of the filter query string variable.
         *
         * @return {string}
         */
        filterParameter() {
            return this.resourceName + '_filter';
        },

        /**
         * Returns the name of the trashed constraint query string variable.
         *
         * @return {string}
         */
        trashedParameter() {
            return this.resourceName + '_trashed';
        }

	}

}
