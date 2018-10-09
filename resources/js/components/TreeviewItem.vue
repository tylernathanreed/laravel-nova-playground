<template>
    <li class="treeview-item">
        <div :class="{'font-bold': isFolder}" @click="toggle">
            {{ item.name }}
            <span v-if="isFolder">[{{ open ? '-' : '+' }}]</span>
        </div>
        <ul class="treeview-menu" v-if="open">
            <treeview-item v-for="(child, index) in item.children" :key="index" :item="child"></treeview-item>
        </ul>
    </li>
</template>

<script>
    export default {

        props: {

            item: {
                label: '',
                children: {}
            }

        },

        data: function () {

            return {
                open: false
            }

        },

        computed: {

            isFolder: function () {
                return this.item.children && this.item.children.length > 0;
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