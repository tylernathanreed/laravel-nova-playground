<template>
    <action-selector
        v-if="actions.length > 0 || availablePivotActions.length > 0"
        :active="false"
        :resource="resource"
        :resource-name="resourceName"
        :actions="actions"
        :pivot-actions="pivotActions"
        :pivot-name="pivotName"
        :query-string="{
            currentSearch,
            encodedFilters,
            currentTrashed,
            viaResource,
            viaResourceId,
            viaRelationship,
        }"
        :relationship-type="relationshipType"
        :via-relationship="viaRelationship"
        :via-resource="viaResource"
        :via-resource-id="viaResourceId"
        :via-many-to-many="viaManyToMany"
        :selected-resources="selectedResourcesForActionSelector"
        @actionExecuted="getResources"
    />
</template>

<script>
import { InteractsWithResourceInformation } from 'laravel-nova'
import {
    HasActions,
    ObtainsActionsFromParentComponent,
    ObtainsQueryStringFromRoute,
} from '../mixins/mixins'

export default {
    mixins: [
        HasActions,
        InteractsWithResourceInformation,
        ObtainsActionsFromParentComponent,
        ObtainsQueryStringFromRoute
    ],

    props: {
        testId: String,
        resource: Object,
        resourceName: String,
        relationshipType: {
            type: String,
            default: null
        },
        viaRelationship: String,
        viaResource: String,
        viaResourceId: String,
        viaManyToMany: Boolean,
    },

    methods: {

        /**
         * Returns the closest component that can refresh the resources.
         *
         * @return {VueComponent|null}
         */
        getResourceRefresher() {

            // Walk up the parent tree
            for(let parent = this.$parent; typeof parent !== 'undefined'; parent = parent.$parent) {

                // Check if the parent has a resource refresher
                if(typeof parent.getResources !== 'undefined') {
                    return parent;
                }

            }

            // Failed to find parent with refresher
            return null;
        },

        /**
         * Updates the resources.
         *
         * @return {void}
         */
        getResources() {

            // Determine the resource refresher
            var refresher = this.getResourceRefresher();

            // Stop if we couldn't find the resource refresher
            if(refresher == null) {
                return;
            }

            // Call the resource refresher
            refresher.getResources();

        }

    },

    computed: {

        /**
         * Returns the selected resources.
         *
         * @return {Array}
         */
        selectedResources() {
            return [this.resource];
        },

        /**
         * Returns the selected resource ids.
         *
         * @return {Array}
         */
        selectedResourceIds() {
            return [this.resource.id.value];
        },

        /**
         * Returns the selected resources for the action selector.
         *
         * @return {Array}
         */
        selectedResourcesForActionSelector() {
            return this.selectedResourceIds;
        }

    }

}
</script>