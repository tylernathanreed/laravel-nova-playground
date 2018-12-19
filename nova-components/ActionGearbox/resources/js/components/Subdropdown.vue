<template>
    <div v-on-clickaway="close" class="subdropdown relative">
        <slot :toggle="toggle" />

        <transition name="fade">
            <slot v-if="visible" name="menu" />
        </transition>
    </div>
</template>

<script>
    import { mixin as clickaway } from 'vue-clickaway'

    export default {

        mixins: [clickaway],

        data: () => ({ visible: false }),

        methods: {

            toggle() {
                this.visible = !this.visible;
            },

            close() {
                this.visible = false;
            },

            showParentOverflow() {
                this.$parent.$el.children[1].classList.remove('overflow-hidden');
            }

        },

        mounted() {

            // Show the overflow in the parent
            this.showParentOverflow();

        }

    }
</script>
