export default {

	methods: {

        /**
         * Returns the closest component that knows the resource and actions.
         *
         * @return {VueComponent|null}
         */
        getActionSource() {

            // Walk up the parent tree
            for(let parent = this.$parent; typeof parent !== 'undefined'; parent = parent.$parent) {

                // Check if the parent has actions
                if(typeof parent.actions !== 'undefined') {
                    return parent;
                }

            }

            // Failed to find parent with actions
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