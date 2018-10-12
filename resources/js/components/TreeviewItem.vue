<template>
    <component :is="tag">
        <div @click="toggle">
            <slot name="label" :label="item.name" :children="item.children" :isFolder="this.isFolder" :open="this.open">
                <span :class="{'font-bold': item.isFolder}">{{ item.label }}</span>
                <span v-if="item.isFolder">[{{ item.open ? '-' : '+' }}]</span>
            </slot>
        </div>
        <ul class="treeview-menu" v-if="open">
            <treeview-item v-for="(child, index) in item.children" :key="index" :item="child">
                <template slot="label" slot-scope="item">
                    <slot name="label" :label="item.name" :children="item.children" :isFolder="this.isFolder" :open="this.open">
                        <span :class="{'font-bold': item.isFolder}">{{ item.label }}</span>
                        <span v-if="item.isFolder">[{{ item.open ? '-' : '+' }}]</span>
                    </slot>
                </template>
            </treeview-item>
        </ul>
    </component>
</template>

<script>
    export default {

        props: {

            tag: {
                type: String,
                default: 'li'
            },

            item: {
                type: Object,
                default: {
                    name: '',
                    children: []
                }
            }

        },

        data: function () {

            return {
                open: false
            }

        },

        computed: {

            isFolder: function () {
                return (typeof this.item.children !== 'undefined') && (this.item.children.length > 0);
            }

        },

        methods: {

            toggle: function () {

                if (this.isFolder) {
                    this.open = !this.open
                }

            },

        }
    }
</script>