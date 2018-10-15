<template>
    <component :is="tag">
        <component :is="toggleTag" :class="toggleClass" @click="toggle">
            <slot name="label"></slot>
        </component>
        <slot name="menu" v-if="open"></slot>
    </component>
</template>

<script>
    export default {

        props: {

            tag: {
                type: String,
                default: 'div'
            },

            toggleTag: {
                type: String,
                default: 'div'
            },

            toggleClass: {
                type: String,
                default: ''
            },

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