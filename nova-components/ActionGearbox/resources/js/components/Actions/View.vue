<template>
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
</template>

<script>
import { InteractsWithResourceInformation } from 'laravel-nova'

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
    ]
}
</script>