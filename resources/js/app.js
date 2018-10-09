
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('treeview', require('./components/Treeview.vue'));
Vue.component('treeview-item', require('./components/TreeviewItem.vue'));

// demo data
var tree = {

  items: [
    { name: 'Dashboard' },
    {
      name: 'Resources',
      children: [
        {
          name: 'Other',
          children: [
            { name: 'Addresses' },
            { name: 'Comments' },
            { name: 'Flights' },
            { name: 'Client Invoice' },
            { name: 'Invoice Item' },
            { name: 'Posts' },
            { name: 'Tags' },
            { name: 'Videos' }
          ]
        },
        {
          name: 'Seafaring',
          children: [
            { name: 'Captains' },
            { name: 'Docks' },
            { name: 'Sails' },
            { name: 'Stips' }
          ]
        },
        {
          name: 'System Settings',
          children: [
            { name: 'Roles' },
            { name: 'Users' }
          ]
        }
      ]
    }
  ]

}


const app = new Vue({

    el: '#app',
	data: {
		tree: tree
	}

});