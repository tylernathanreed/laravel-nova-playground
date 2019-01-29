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
                            class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
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
                            class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
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
                            class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
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

                    <!-- Resource Actions -->
                    <subdropdown v-if="resourceActions.length > 0">
                        <subdropdown-trigger class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg" slot-scope="{toggle}" :handle-click="toggle">
                            <icon type="resource" class="mr-3"/>
                            <div v-text="resourceInformation.singularLabel" class="flex-1"></div>
                        </subdropdown-trigger>

                        <subdropdown-menu slot="menu" width="200" pull="left">
                            <div
                                v-for="action in resourceActions"
                                class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
                                @click="openConfirmationModal(action)"
                            >
                                <icon type="play" class="mr-3" />
                                <div>{{ action.name}}</div>
                            </div>
                        </subdropdown-menu>
                    </subdropdown>

                    <!-- Resource Pivot Actions -->
                    <subdropdown v-if="resourcePivotActions.actions.length > 0">
                        <subdropdown-trigger class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg" slot-scope="{toggle}" :handle-click="toggle">
                            <icon type="resource" class="mr-3"/>
                            <div v-text="resourcePivotActions.name" class="flex-1"></div>
                        </subdropdown-trigger>

                        <subdropdown-menu slot="menu" width="200" pull="left">
                            <div
                                v-for="action in resourcePivotActions.actions"
                                class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
                                @click="openConfirmationModal(action, true)"
                            >
                                <icon type="play" class="mr-3" />
                                <div>{{ action.name}}</div>
                            </div>
                        </subdropdown-menu>
                    </subdropdown>

                    <!-- Delete Resource Link -->
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

                    <!-- Restore Resource Link -->
                    <button
                        :dusk="`${resource['id'].value}-restore-button`"
                        class="appearance-none cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
                        v-if="resource.authorizedToRestore && resource.softDeleted && ! viaManyToMany"
                        @click.prevent="openRestoreModal"
                        :title="__('Restore')"
                    >
                        <icon type="restore" class="mr-3" width="20" height="21" />
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

            <!-- Action Confirmation Modal -->
            <transition name="fade">
                <confirm-action-modal
                    :working="working"
                    v-if="confirmActionModalOpened"
                    :resource-name="resourceName"
                    :selected-action="selectedAction"
                    :errors="errors"
                    @confirm="executeAction"
                    @close="confirmActionModalOpened = false"
                />
            </transition>
        </portal>
    </div>
</template>

<script>
import _ from 'lodash'
import { Errors, InteractsWithResourceInformation } from 'laravel-nova'

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

        deleteModalOpen: false,
        restoreModalOpen: false,
        working: false,
        errors: new Errors(),
        selectedAction: null,
        selectedActionIsPivotAction: false,
        confirmActionModalOpened: false

    }),

    methods: {

        /**
         * Confirm with the user that they actually want to run the selected action.
         *
         * @param  {Object}   action  The selected action.
         * @param  {boolean}  pivot   Whether or not the action is a pivot action.
         *
         * @return {void}
         */
        openConfirmationModal(action, pivot = false) {

            this.selectedAction = action;
            this.selectedActionIsPivotAction = pivot;
            this.confirmActionModalOpened = true;

        },

        /**
         * Close the action confirmation modal.
         */
        closeConfirmationModal() {
            this.confirmActionModalOpened = false;
        },

        /**
         * Execute the selected action.
         */
        executeAction() {

            // Set this action as working
            this.working = true;

            // Submit the request
            Nova.request({
                method: 'post',
                url: this.endpoint || `/nova-api/${this.resourceName}/action`,
                params: this.actionRequestQueryString,
                data: this.actionFormData(),
            })

                // Handle the response
                .then(response => {

                    this.confirmActionModalOpened = false;
                    this.handleActionResponse(response.data);
                    this.working = false;

                })

                // Catch any errors
                .catch(error => {

                    this.working = false;

                    if(error.response.status == 422) {
                        this.errors = new Errors(error.response.data.errors)
                    }

                })

        },

        /**
         * Gather the action FormData for the given action.
         *
         * @return {FormData}
         */
        actionFormData() {

            return _.tap(new FormData(), formData => {

                formData.append('resources', [this.resource.id.value]);

                _.each(this.selectedAction.fields, field => {
                    field.fill(formData)
                });

            });

        },

        /**
         * Handle the action response. Typically either a message, download or a redirect.
         *
         * @param  {object}  response
         *
         * @return {void}
         */
        handleActionResponse(response) {

            // Check for a message
            if(response.message) {
                this.$emit('actionExecuted');
                this.$toasted.show(response.message, { type: 'success' });
            }

            // Check if the response was deleted
            else if(response.deleted) {
                this.$emit('actionExecuted')
            }

            // Check for a danger response
            else if(response.danger) {
                this.$emit('actionExecuted')
                this.$toasted.show(response.danger, { type: 'error' })
            }

            // Check for a download response
            else if (response.download) {
                let link = document.createElement('a')
                link.href = response.download
                link.download = response.name
                link.click()
            }

            // Check for a redirect response
            else if (response.redirect) {
                window.location = response.redirect
            }

            // Assume the action was successful
            else {
                this.$emit('actionExecuted')
                this.$toasted.show(this.__('The action ran successfully!'), { type: 'success' })
            }

        },

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

    computed: {

        /**
         * Computed alias of {@see $this.getResourceActions()}.
         *
         * @return {Array}
         */
        resourceActions() {
            return this.getResourceActions();
        },

        /**
         * Computed alias of {@see $this.getResourcePivotActions()}.
         *
         * @return {Array}
         */
        resourcePivotActions() {
            return this.getResourcePivotActions();
        },

        /**
         * Returns the query string for an action request.
         *
         * @return {Object}
         */
        actionRequestQueryString() {
            return {
                action: this.selectedAction.uriKey,
                pivotAction: this.selectedActionIsPivotAction,
                search: this.queryString.currentSearch,
                filters: this.queryString.encodedFilters,
                trashed: this.queryString.currentTrashed,
                viaResource: this.queryString.viaResource,
                viaResourceId: this.queryString.viaResourceId,
                viaRelationship: this.queryString.viaRelationship,
            }
        },

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
        },

    }

}
</script>