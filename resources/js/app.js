require('./bootstrap');

import Vue from 'vue'

import VueRouter from 'vue-router';
Vue.use(VueRouter)

import VueSweetalert2 from 'vue-sweetalert2';

import 'sweetalert2/dist/sweetalert2.min.css';

import { ValidationProvider } from 'vee-validate';

Vue.component('ValidationProvider', ValidationProvider);

Vue.use(VueSweetalert2);

import routes from './routes'

import App from './components/App.vue'


Vue.component('pagination', require('laravel-vue-pagination'));


const app = new Vue({
    el:'#app',
    components: { App },
    router: new VueRouter(routes)
});
