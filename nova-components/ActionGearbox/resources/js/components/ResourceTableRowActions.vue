<template>
    <div>
        <dropdown class="bg-30 hover:bg-40 mr-3 rounded">
            <dropdown-trigger class="px-3" slot-scope="{toggle}" :handle-click="toggle">
                <icon type="actions-gearbox" class="text-80" />
            </dropdown-trigger>

            <dropdown-menu slot="menu" width="200" direction="rtl">
                <div class="text-left">
                    <!-- View Resource Link -->
                    <span v-if="resource.authorizedToView">
                        <router-link
                            :data-testid="`${testId}-view-button`"
                            :dusk="`${resource['id'].value}-view-button`"
                            class="cursor-pointer text-70 hover:text-primary mr-3 p-3 block"
                            :to="{ name: 'detail', params: {
                                resourceName: resourceName,
                                resourceId: resource['id'].value
                            }}"
                            :title="__('View')"
                        >
                            <icon type="view" width="22" height="18" view-box="0 0 22 16" />
                        </router-link>
                    </span>

                    <span v-if="resource.authorizedToUpdate">
                        <!-- Edit Pivot Button -->
                        <router-link
                            v-if="relationshipType == 'belongsToMany' || relationshipType == 'morphToMany'"
                            class="cursor-pointer text-70 hover:text-primary p-3 block"
                            :dusk="`${resource['id'].value}-edit-attached-button`"
                            :to="{
                                name: 'edit-attached',
                                params: {
                                    resourceName: viaResource,
                                    resourceId: viaResourceId,
                                    relatedResourceName: resourceName,
                                    relatedResourceId: resource['id'].value
                                },
                                query: {
                                    viaRelationship: viaRelationship
                                }
                            }"
                            :title="__('Edit Attached')"
                        >
                            <icon type="edit" />
                        </router-link>

                        <!-- Edit Resource Link -->
                        <router-link
                            v-else
                            class="cursor-pointer text-70 hover:text-primary p-3 block"
                            :dusk="`${resource['id'].value}-edit-button`"
                            :to="{
                                name: 'edit',
                                params: {
                                    resourceName: resourceName,
                                    resourceId: resource['id'].value
                                },
                                query: {
                                    viaResource: viaResource,
                                    viaResourceId: viaResourceId,
                                    viaRelationship: viaRelationship
                                }
                            }"
                            :title="__('Edit')"
                        >
                            <icon type="edit" />
                        </router-link>
                    </span>

                    <!-- Delete Resource Link -->
                    <button
                        :data-testid="`${testId}-delete-button`"
                        :dusk="`${resource['id'].value}-delete-button`"
                        class="appearance-none cursor-pointer text-70 hover:text-primary p-3 block"
                        v-if="resource.authorizedToDelete && (! resource.softDeleted || viaManyToMany)"
                        @click.prevent="openDeleteModal"
                        :title="__(viaManyToMany ? 'Detach' : 'Delete')"
                    >
                        <icon />
                    </button>

                    <!-- Restore Resource Link -->
                    <button
                        :dusk="`${resource['id'].value}-restore-button`"
                        class="appearance-none cursor-pointer text-70 hover:text-primary p-3 block"
                        v-if="resource.authorizedToRestore && resource.softDeleted && ! viaManyToMany"
                        @click.prevent="openRestoreModal"
                        :title="__('Restore')"
                    >
                        <icon type="restore" with="20" height="21" />
                    </button>
                </div>
            </dropdown-menu>
        </dropdown>

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
        deleteModalOpen: false,
        restoreModalOpen: false,
    }),

    methods: {
        /**
         * Select the resource in the parent component
         */
        toggleSelection() {
            this.updateSelectionStatus(this.resource)
        },

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
    },
}
</script>