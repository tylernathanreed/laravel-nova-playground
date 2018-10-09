<template>
    <component :is="tag">
        <treeview-item class="treeview-item" v-for="(item, index) in items" :key="index" :item="item"></treeview-item>
    </component>
</template>

<script>
    export default {

        props: {
            tag: {
                type: String,
                default: 'ul'
            },
            items: {
                type: Array,
                default: []
            }
        }

    }
</script>