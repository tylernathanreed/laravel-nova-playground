<template>
    <div>
        <dropdown class="bg-30 hover:bg-40 mr-3 rounded" v-if="this.hasAnyAuthorizations()">
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
                            class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline"
                            :to="{ name: 'detail', params: {
                                resourceName: resourceName,
                                resourceId: resource['id'].value
                            }}"
                            :title="__('View')"
                        >
                            <icon type="view" class="mr-3" width="22" height="16" view-box="0 0 22 16" />
                            <div>{{ __('Details') }}</div>
                        </router-link>
                    </span>

                    <span v-if="resource.authorizedToUpdate">
                        <!-- Edit Pivot Button -->
                        <router-link
                            v-if="relationshipType == 'belongsToMany' || relationshipType == 'morphToMany'"
                            class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline"
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
                            <icon type="edit" class="mr-3" />
                            <div>{{ __('Edit Attached') }}</div>
                        </router-link>

                        <!-- Edit Resource Link -->
                        <router-link
                            v-else
                            class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline"
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
                            <icon type="edit" class="mr-3" />
                            <div>{{ __('Edit') }}</div>
                        </router-link>
                    </span>

                    <!-- Delete Resource Link -->
                    <button
                        :data-testid="`${testId}-delete-button`"
                        :dusk="`${resource['id'].value}-delete-button`"
                        class="appearance-none cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline w-full"
                        v-if="resource.authorizedToDelete && (! resource.softDeleted || viaManyToMany)"
                        @click.prevent="openDeleteModal"
                        :title="__(viaManyToMany ? 'Detach' : 'Delete')"
                    >
                        <icon class="mr-3" />
                        <div v-text="__(viaManyToMany ? 'Detach' : 'Delete')"></div>
                    </button>

                    <!-- Resource Actions -->
                    <!-- Resource Pivot Actions -->

                    <!-- Restore Resource Link -->
                    <button
                        :dusk="`${resource['id'].value}-restore-button`"
                        class="appearance-none cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline"
                        v-if="resource.authorizedToRestore && resource.softDeleted && ! viaManyToMany"
                        @click.prevent="openRestoreModal"
                        :title="__('Restore')"
                    >
                        <icon type="restore" class="mr-3" with="20" height="21" />
                        <div>{{ __('Restore') }}</div>
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

}
</script>