Nova.booting((Vue, router) => {

    Vue.component('resource-table', require('./components/ResourceTable'));
    Vue.component('resource-table-row', require('./components/ResourceTableRow'));
    Vue.component('resource-table-row-actions', require('./components/ResourceTableRowActions'));

    Vue.component('view-resource-action', require('./components/Actions/View'));
    Vue.component('edit-attached-resource-action', require('./components/Actions/EditAttached'));
    Vue.component('edit-resource-action', require('./components/Actions/Edit'));
    Vue.component('resource-actions-dropdown', require('./components/Actions/ResourceActionsDropdown'));
    Vue.component('resource-pivot-actions-dropdown', require('./components/Actions/ResourcePivotActionsDropdown'));
    Vue.component('delete-resource-action', require('./components/Actions/Delete'));
    Vue.component('restore-resource-action', require('./components/Actions/Restore'));

    Vue.component('icon-actions-gearbox', require('./components/Icons/Actions'));
    Vue.component('icon-resource', require('./components/Icons/Resource'));

    Vue.component('subdropdown', require('./components/Subdropdown'));
    Vue.component('subdropdown-trigger', require('./components/SubdropdownTrigger'));
    Vue.component('subdropdown-menu', require('./components/SubdropdownMenu'));

})
