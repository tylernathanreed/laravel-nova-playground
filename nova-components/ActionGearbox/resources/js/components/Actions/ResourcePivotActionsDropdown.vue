<template>
    <div>
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

        <portal to="modals">
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
import { Errors, InteractsWithResourceInformation } from 'laravel-nova'
import { InteractsWithResourceActions } from '../../mixins/mixins'

export default {
    mixins: [InteractsWithResourceInformation, InteractsWithResourceActions],

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

        working: false,
        errors: new Errors(),
        selectedAction: null,
        selectedActionIsPivotAction: false,
        confirmActionModalOpened: false

    })

}
</script>