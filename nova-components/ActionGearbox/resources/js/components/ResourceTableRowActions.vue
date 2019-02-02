<template>
    <dropdown class="bg-30 hover:bg-40 mr-3 rounded" v-if="this.hasAnyAuthorizations() && actionComponents.length > 0">
        <dropdown-trigger class="px-3" slot-scope="{toggle}" :handle-click="toggle">
            <icon type="actions-gearbox" class="text-80" />
        </dropdown-trigger>

        <dropdown-menu slot="menu" width="200" direction="rtl">
            <div class="text-left">

                <component
                    v-for="(actionComponent, index) in actionComponents"
                    :key="`resource-action-component-${index}`"
                    :is="actionComponent"
                    :restore-resource="restoreResource"
                    :resource="resource"
                    :resource-name="resourceName"
                    :relationship-type="relationshipType"
                    :via-relationship="viaRelationship"
                    :via-resource="viaResource"
                    :via-resource-id="viaResourceId"
                    :via-many-to-many="viaManyToMany"
                />

            </div>
        </dropdown-menu>
    </dropdown>
</template>

<script>
import _ from 'lodash'
import { InteractsWithResourceInformation } from 'laravel-nova'

export default {
    mixins: [InteractsWithResourceInformation],

    props: {
        actionComponents: {
            type: Array,
            default: function() {
                return [
                    'view-resource-action',
                    'edit-attached-resource-action',
                    'edit-resource-action',
                    'resource-actions-dropdown',
                    'resource-pivot-actions-dropdown',
                    'delete-resource-action',
                    'restore-resource-action',
                ];
            }
        },
        testId: { default: '' },
        deleteResource: { default: '' },
        restoreResource: { default: '' },
        resource: { default: '' },
        resourcesSelected: { default: '' },
        resourceName: { default: '' },
        relationshipType: { default: '' },
        viaRelationship: { default: '' },
        viaResource: { default: '' },
        viaResourceId: { default: '' },
        viaManyToMany: { default: '' },
        checked: { default: '' },
        actionsAreAvailable: { default: '' },
        shouldShowCheckboxes: { default: '' },
        updateSelectionStatus: { default: '' },
        endpoint: { default: '' },
    },

    data: () => ({
        restoreModalOpen: false,
    }),

    methods: {

        /**
         * Select the resource in the parent component
         */
        toggleSelection() {
            this.updateSelectionStatus(this.resource)
        },

        openRestoreModal() {
            this.restoreModalOpen = true
        },

        confirmRestore() {
            this.restoreResource(this.resource)
            this.closeRestoreModal()
        },

        closeRestoreModal() {
            this.restoreModalOpen = false
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

    }

}
</script>