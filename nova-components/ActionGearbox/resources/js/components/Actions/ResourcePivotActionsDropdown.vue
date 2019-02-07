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
                    @click="onActionSelected(action)"
                >
                    <icon type="play" class="mr-3" />
                    <div>{{ action.name}}</div>
                </div>
            </subdropdown-menu>
        </subdropdown>
    </div>
</template>

<script>
import { InteractsWithResourceInformation } from 'laravel-nova'

export default {
    mixins: [InteractsWithResourceInformation],

    props: [
        'testId',
        'resource',
        'resourceName',
        'resourcePivotActions',
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

    methods: {

        onActionSelected: function(action) {
            this.$emit('onActionSelected', action, true);
        }

    }

}
</script>