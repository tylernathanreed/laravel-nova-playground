<template>
    <tr
        :dusk="resource['id'].value + '-row'"
        @mouseover="hovered = true"
        @mouseleave="hovered = false"
    >
        <!-- Resource Selection Checkbox -->
        <td :class="{
            'w-16' : shouldShowCheckboxes,
            'w-8' : !shouldShowCheckboxes
        }">
            <checkbox
                :data-testid="`${testId}-checkbox`"
                :dusk="`${resource['id'].value}-checkbox`"
                v-if="shouldShowCheckboxes"
                :checked="checked"
                @input="toggleSelection"
            />
        </td>

        <!-- Fields -->
        <td v-for="field in resource.fields">
            <component
                :is="'index-' + field.component"
                :class="`text-${field.textAlign}`"
                :resource-name="resourceName"
                :via-resource="viaResource"
                :via-resource-id="viaResourceId"
                :field="field"
            />
        </td>

        <td class="td-fit text-right pr-6">
            <resource-table-row-actions
                :testId="testId"
                :resource="resource"
                :resource-name="resourceName"
                :relationship-type="relationshipType"
                :via-relationship="viaRelationship"
                :via-resource="viaResource"
                :via-resource-id="viaResourceId"
                :via-many-to-many="viaManyToMany"
                @actionExecuted="actionExecuted"
            >
            </resource-table-row-actions>
        </td>
    </tr>
</template>

<script>
export default {
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
    ],

    data: () => ({
        hovered: false
    }),

    methods: {

        /**
         * Select the resource in the parent component
         */
        toggleSelection() {
            this.updateSelectionStatus(this.resource)
        }

    },
}
</script>
