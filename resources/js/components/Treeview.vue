<template>
    <component :is="tag">
        <slot name="label" @click="toggle"></slot>
        <slot name="menu" v-if="open"></slot>
    </component>
</template>

<script>
    export default {

        props: {

            tag: {
                type: String,
                default: 'div'
            }

        },

        data: function () {

            return {
                open: false
            }

        },

        methods: {

            toggle: function () {
                this.open = !this.open;
            },

        }

    }
</script>