<template>
    <div>
        <button
            :data-testid="`${testId}-delete-button`"
            :dusk="`${resource['id'].value}-delete-button`"
            class="appearance-none cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline w-full rounded-lg"
            v-if="resource.authorizedToDelete && (! resource.softDeleted || viaManyToMany)"
            @click.prevent="openDeleteModal"
            :title="__(viaManyToMany ? 'Detach' : 'Delete')"
        >
            <icon class="mr-3" />
            <div v-text="__(viaManyToMany ? 'Detach' : 'Delete')"></div>
        </button>

        <portal to="modals">
            <transition name="fade">
                <delete-resource-modal
                    v-if="deleteModalOpen"
                    @confirm="confirmDelete"
                    @close="closeDeleteModal"
                    :mode="viaManyToMany ? 'detach' : 'delete'"
                >
                    <div slot-scope="{ uppercaseMode, mode }" class="p-8">
                        <heading :level="2" class="mb-6">{{ __(uppercaseMode+' Resource') }}</heading>
                        <p class="text-80 leading-normal">{{__('Are you sure you want to '+mode+' this resource?')}}</p>
                    </div>
                </delete-resource-modal>
            </transition>
        </portal>
    </div>
</template>

<script>
import { Errors, InteractsWithResourceInformation } from 'laravel-nova'

export default {
    mixins: [InteractsWithResourceInformation],

    props: [
        'testId',
        'resource',
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
        deleteModalOpen: false,
    }),

    methods: {

        openDeleteModal() {
            this.deleteModalOpen = true
        },

        confirmDelete() {
            this.deleteResource(this.resource)
            this.closeDeleteModal()
        },

        closeDeleteModal() {
            this.deleteModalOpen = false
        },

    }
}
</script>