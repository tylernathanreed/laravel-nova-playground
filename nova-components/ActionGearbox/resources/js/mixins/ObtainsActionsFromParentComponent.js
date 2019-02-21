export default {

	methods: {

        /**
         * Returns the closest component in the parent tree matching the specified name.
         *
         * @param  {string}  name
         *
         * @return {VueComponent|null}
         */
        getClosestComponent(name) {

            // Walk up the parent tree
            for(let parent = this.$parent; typeof parent !== 'undefined'; parent = parent.$parent) {

                // Return the eparent if it is a resource index
                if(parent.$options.name === name) {
                    return parent;
                }

            }

            // Failed to find resource index
            return null;

        },

        /**
         * Returns the closest resource index in the parent tree.
         *
         * @return {VueComponent|null}
         */
        getResourceIndex() {
            return this.getClosestComponent('resource-index');
        },

        /**
         * Returns the closest lens in the parent tree.
         *
         * @return {VueComponent|null}
         */
        getLens() {
            return this.getClosestComponent('lens');
        },

        /**
         * Returns the closest component that knows the resource and pivot actions.
         *
         * @return {VueComponent|null}
         */
        getActionSource() {

            // Initialize the source
            let source = null;

            // Try to find the resource index
            if((source = this.getResourceIndex()) !== null) {
                return source;
            }

            // Try to find the lens
            if((source = this.getLens()) !== null) {
                return source;
            }

            // Unknown source
            return null;
        },

        /**
         * Returns the available resource actions.
         *
         * @return {Array}
         */
        getResourceActions() {
            return this.getActionSource().actions;
        },

        /**
         * Returns the available resource pivot actions.
         *
         * @return {Array}
         */
        getResourcePivotActions() {
            return this.getActionSource().pivotActions;
        }

    },

    computed: {

        /**
         * Computed alias of {@see $this.getResourceActions()}.
         *
         * @return {Array}
         */
        actions() {
            return this.getResourceActions();
        },

        /**
         * Computed alias of {@see $this.getResourcePivotActions()}.
         *
         * @return {Array}
         */
        pivotActions() {
            return this.getResourcePivotActions();
        }

    }
}