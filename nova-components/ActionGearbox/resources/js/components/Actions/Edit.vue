<template>
    <span v-if="resource.authorizedToUpdate">
        <router-link
            v-if="relationshipType != 'belongsToMany' && relationshipType != 'morphToMany'"
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