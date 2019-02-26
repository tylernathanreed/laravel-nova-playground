<template>
    <loading-view :loading="initialLoading" :dusk="resourceName + '-index-component'">
        <custom-index-header v-if="!viaResource" class="mb-3" :resource-name="resourceName" />

        <div v-if="shouldShowCards">
            <cards
                v-if="smallCards.length > 0"
                :cards="smallCards"
                class="mb-3"
                :resource-name="resourceName"
            />

            <cards
                v-if="largeCards.length > 0"
                :cards="largeCards"
                size="large"
                :resource-name="resourceName"
            />
        </div>

        <resource-panel
            :field="field"
            :resource-name="resourceName"
            :via-resource="viaResource"
            :via-resource-id="viaResourceId"
            :via-relationship="viaRelationship"
            :relationshipType="relationshipType"
            @loaded="initialLoading = false"
        />

    </loading-view>
</template>

<script>
import {
    Errors,
    HasCards,
} from 'laravel-nova'

export default {
    mixins: [
        HasCards,
    ],

    props: {
        field: {
            type: Object,
        },
        resourceName: {
            type: String,
            required: true,
        },
        viaResource: {
            default: '',
        },
        viaResourceId: {
            default: '',
        },
        viaRelationship: {
            default: '',
        },
        relationshipType: {
            type: String,
            default: '',
        },
    },

    data: () => ({
        initialLoading: true,
    }),

    computed: {

        /**
         * Determine if the resource should show any cards
         */
        shouldShowCards() {
            // Don't show cards if this resource is beings shown via a relations
            return this.cards.length > 0 && this.resourceName == this.$route.params.resourceName
        },

        /**
         * Get the endpoint for this resource's metrics.
         */
        cardsEndpoint() {
            return `/nova-api/${this.resourceName}/cards`
        },

    },
}
</script>
