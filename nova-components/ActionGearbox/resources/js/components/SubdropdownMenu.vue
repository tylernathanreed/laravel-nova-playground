<template>
    <div class="subdropdown-menu absolute z-50 select-none pin-t" :class="menuClasses" :style="menuStyles">
        <div :style="styles" class="z-40 bg-white border border-60 shadow rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>
    export default {

        props: {

            direction: {
                type: String,
                default: 'ltr',
                validator: value => ['ltr', 'rtl'].indexOf(value) != -1,
            },

            pull: {
                type: String,
                default: 'right',
                validator: value => ['right', 'left'].indexOf(value) != -1,
            },

            width: {
                default: 120,
            }

        },

        computed: {

            menuClasses() {
                return [this.direction == 'ltr' ? 'subdropdown-menu-left' : 'subdropdown-menu-right']
            },

            menuStyles() {
                return {
                    left: this.pull == 'left' ? `-${this.width}px` : `${+this.width - 2}px`
                }
            },

            styles() {
                return {
                    width: `${this.width}px`,
                }
            }

        },
    }
</script>
