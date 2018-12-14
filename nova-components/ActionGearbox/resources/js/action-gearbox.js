Nova.booting((Vue, router) => {
    Vue.component('resource-table', require('./components/ResourceTable'));
    Vue.component('resource-table-row', require('./components/ResourceTableRow'));
    Vue.component('resource-table-row-actions', require('./components/ResourceTableRowActions'));
    Vue.component('icon-actions-gearbox', require('./components/Icons/Actions'));
    Vue.component('icon-resource', require('./components/Icons/Resource'));
})
