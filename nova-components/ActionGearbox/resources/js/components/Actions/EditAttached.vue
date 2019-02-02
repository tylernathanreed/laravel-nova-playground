<template>
    <span v-if="resource.authorizedToUpdate">
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