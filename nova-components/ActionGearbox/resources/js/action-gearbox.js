Nova.booting((Vue, router) => {

    Vue.component('resource-table', require('./components/ResourceTable'));
    Vue.component('resource-table-row', require('./components/ResourceTableRow'));
    Vue.component('resource-table-row-actions', require('./components/ResourceTableRowActions'));

    Vue.component('action-selector', require('./components/ActionSelector'));

    Vue.component('action-item', require('./components/ActionItem'));
    Vue.component('action-group', require('./components/ActionGroup'));

    Vue.component('icon-actions-gearbox', require('./components/icons/Actions'));
    Vue.component('icon-resource', require('./components/icons/Resource'));

    Vue.component('subdropdown', require('./components/Subdropdown'));
    Vue.component('subdropdown-trigger', require('./components/SubdropdownTrigger'));
    Vue.component('subdropdown-menu', require('./components/SubdropdownMenu'));

    Vue.component('confirm-action-modal', require('./components/ConfirmActionModal'));

})
