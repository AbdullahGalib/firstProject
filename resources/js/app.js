/**
 * Require file
 */
// require boatstrap
require('./bootstrap');

window.Vue = require('vue').default;

//  vue router

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import {routes} from './router/routes';
const router = new VueRouter({
    routes,
   // mode: 'history',
})

// Vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from './vuex/store'
const store = new Vuex.Store(
    storeData,
)


// Moment Js
import {filter} from './filter/filter'


// V Form
import { Form, HasError, AlertError } from 'vform'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form = Form;

// SwetAlert
import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

window.Toast = Toast;


//toastr
import toastr from 'toastr'
import Vue from 'vue';
window.toastr = toastr;

//Helpers

import './helpers/mixin'

/**
 *  Vue componenet
 */

Vue.component('home', require('./components/ExampleComponent.vue').default);

/**
 * Vue js
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
