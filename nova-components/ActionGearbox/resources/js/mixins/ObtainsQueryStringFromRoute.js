export default {

	methods: {

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