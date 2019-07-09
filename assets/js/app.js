/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('../js/loadScripts.js');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('login-component', require('./components/LoginComponent.vue').default);

Vue.component('register-component', require('./components/RegisterComponent.vue').default);

Vue.component('request-password-component', require('./components/RequestPasswordComponent.vue').default);

Vue.component('modal-component', require('./components/DialogComponent.vue').default);

Vue.component('message-component', require('./components/MessageComponent.vue').default);

Vue.component('pulse-loader', require('vue-spinner/src/PulseLoader.vue').default);

Vue.component('datepicker-component', require('./components/DatepickerComponent').default);

Vue.component('forum-category-component', require('./components/ForumCategoryComponent').default);

Vue.component('cart-component', require('./components/CartComponent').default);

Vue.component('cart-totals-component', require('./components/CartTotalsComponent').default);

Vue.component('add-to-cart-component', require('./components/AddToCartComponent').default);

Vue.component('cart-items-count-component', require('./components/CartItemsCountComponent').default);

Vue.component('product-price-calculation-component', require('./components/ProductPriceCalculationComponent').default);

Vue.component('product-calendar-booking-component', require('./components/ProductBookingCalendarComponent').default);

Vue.component('product-booking-component', require('./components/ProductBookingComponent').default);

Vue.component('product-variant-component', require('./components/ProductVariantComponent').default);

window.EventBus = new Vue();

const app = new Vue({
    el: '#app',
});