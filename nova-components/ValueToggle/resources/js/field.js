Nova.booting((Vue, router) => {
    Vue.component('index-ValueToggle', require('./components/IndexField'));
    Vue.component('detail-ValueToggle', require('./components/DetailField'));
    Vue.component('form-ValueToggle', require('./components/FormField'));
})
