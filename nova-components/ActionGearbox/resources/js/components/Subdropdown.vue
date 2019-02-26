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
                this.dropdown.$el.children[0].classList.remove('overflow-hidden');
            },

            putParentBehindModalSplash() {
                this.dropdown.$el.classList.remove('z-50');
                this.dropdown.$el.classList.add('z-20');
            },


            /**
             * Returns the dropdown menu in the parent tree.
             *
             * @return {VueComponent|null}
             */
            getDropdownMenu() {

                // Walk up the parent tree
                for(let parent = this.$parent; typeof parent !== 'undefined'; parent = parent.$parent) {

                    // Return the parent if it is a dropdown menu
                    if(parent.$options.name === 'dropdown-menu') {
                        return parent;
                    }

                }

                // Failed to find dropdown menu
                return null;

            },

        },

        computed: {

            dropdown() {
                return this.getDropdownMenu();
            }

        },

        mounted() {

            // Show the overflow in the parent
            this.showParentOverflow();

            // Put the dropdown behind the modal splash
            this.putParentBehindModalSplash();

        }

    }
</script>
