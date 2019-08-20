/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('../js/loadScripts.js');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';

Vue.use(VueRouter);
Vue.use(VueCookies);
VueCookies.config('7d');

window.EventBus = new Vue();

const _ = require('lodash');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.trans = string => _.get(window.i18n, string);

const router = new VueRouter({
    routes: require('./components/routes/web'),
    mode: 'history'
});

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const app = new Vue({
    router
}).$mount('#app');
