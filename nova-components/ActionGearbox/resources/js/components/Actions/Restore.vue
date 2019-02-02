<template>
    <div>
        <button
            :dusk="`${resource['id'].value}-restore-button`"
            class="appearance-none cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline w-full rounded-lg"
            v-if="resource.authorizedToRestore && resource.softDeleted && ! viaManyToMany"
            @click.prevent="openRestoreModal"
            :title="__('Restore')"
        >
            <icon type="restore" class="mr-3" width="20" height="21" />
            <div>{{ __('Restore') }}</div>
        </button>

        <portal to="modals">
            <transition name="fade">
                <restore-resource-modal
                    v-if="restoreModalOpen"
                    @confirm="confirmRestore"
                    @close="closeRestoreModal"
                >
                    <div class="p-8">
                        <heading :level="2" class="mb-6">{{__('Restore Resource')}}</heading>
                        <p class="text-80 leading-normal">{{__('Are you sure you want to restore this resource?')}}</p>
                    </div>
                </restore-resource-modal>
            </transition>
        </portal>
    </div>
</template>

<script>
import { InteractsWithResourceInformation } from 'laravel-nova'

export default {
    mixins: [InteractsWithResourceInformation],

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
        restoreModalOpen: false,
    }),

    methods: {

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

    }

}
</script>