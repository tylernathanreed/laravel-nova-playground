<template>
    <component
        :is="'form-' + field.field.component"
        :errors="errors"
        :resource-id="resourceId"
        :resource-name="resourceName"
        :field="field.field"
        v-if="conditionIsTrue()"
    />
</template>

<script>

import { FormField, HandlesValidationErrors } from 'laravel-nova'
import { FormValues, ToggleBuilder } from '../mixins/mixins'

export default {

    mixins: [FormField, HandlesValidationErrors, FormValues, ToggleBuilder],

    props: ['resourceName', 'resourceId', 'field'],

    methods: {

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        }

    },

    computed: {

        form() {
            return this.getFormComponent();
        }

    }

}
</script>
