<template>
    <component
        :is="'form-' + field.field.component"
        :errors="errors"
        :resource-id="resourceId"
        :resource-name="resourceName"
        :field="field.field"
    />
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

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
        },

        /**
         * Returns the node that contains the fields for the form.
         *
         * @return {object|null}
         */
        getNodeContainingFields() {

            // Start with the parent
            let node = this.$parent;

            // Walk up the parent chain
            while(typeof node !== 'undefined' && node !== null) {

                // Check for a "fields" property
                if(node.hasOwnProperty('fields')) {
                    return node;
                }

                // Walk up the chain
                node = node.$parent;

            }

            // Unknown
            return null;

        },

        /**
         * Returns the field with the specified attribute name.
         *
         * @param  {string}  key
         *
         * @return {object|undefined}
         */
        getField(key) {

            // Determine the node containing the fields
            let node = this.getNodeContainingFields() || {};

            // Determine the fields
            let fields = node.fields || [];

            // Search the fields for the specified field
            for(let i = 0; i < fields.length; i++) {

                // Determine the field
                let field = fields[i];

                // Return the field on a match
                if(field.attribute == key) {
                    return field;
                }

            }

            // Unknown
            return undefined;

        },

        /**
         * Returns the value for the specified field.
         *
         * @param  {string}  key
         *
         * @return {mixed}
         */
        getFieldValue(key) {

            // Determine the field
            let field = this.getField(key) || {};

            // Return the value
            return field.value;

        },

        /**
         * Returns the value for the specified attibute key.
         *
         * @param  {string}  key
         *
         * @return {mixed}
         */
        attr(key) {
            return this.getFieldValue(key);
        }

    },

    computed: {

        form() {
            return this.getNodeContainingFields();
        }

    }

}
</script>
