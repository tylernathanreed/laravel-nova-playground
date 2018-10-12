<template>
    <component :is="tag">
        <treeview-item :tag="itemTag" v-for="(item, index) in items" :key="index" :item="item">
            <template slot="label" slot-scope="item">
                <span :class="{'font-bold': item.isFolder}">{{ item.label }}</span>
                <span v-if="item.isFolder">[{{ item.open ? '-' : '+' }}]</span>
            </template>
        </treeview-item>
    </component>
</template>

<script>
    export default {

        props: {

            tag: {
                type: String,
                default: 'ul'
            },

            'itemTag': {
                type: String,
                default: 'li'

            },

            items: {
                type: Array,
                default: []
            }

        }

    }
</script>