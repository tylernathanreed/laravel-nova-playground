<template>
    <component :is="tag">
        <component :is="toggleTag" @click="toggle" :class="toggleClass">
            <slot name="label"></slot>
            <slot name="label-open" v-if="open"></slot>
            <slot name="label-closed" v-if="!open"></slot>
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
            }

        },

        data: function() {

            return {
                open: false
            }

        },

        methods: {

            toggle: function() {
                this.open = !this.open;
            }

        }

    }
</script>