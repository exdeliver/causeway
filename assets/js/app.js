/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('../js/loadScripts.js');

import Vue from 'vue';
import VueRouter from 'vue-router';
window.EventBus = new Vue();

const _ = require('lodash');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.trans = string => _.get(window.i18n, string);

const req = require.context('./components/', true, /\.(js|vue)$/i);
req.keys().map(key => {
    const name = key.match(/\w+/)[0];
    return Vue.component(name, req(key).default)
});

Vue.use(VueRouter);

var webRoutes = require('./components/routes/web');

var router = new VueRouter(
    webRoutes
);

console.log(router);
const app = new Vue({
    el: '#app',
    router
});