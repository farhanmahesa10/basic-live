/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import draggable from 'vuedraggable'


import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
Vue.filter('numFormat', numFormat(numeral));

import VueMoment from 'vue-moment';
Vue.use(VueMoment);

//<router set up
import VueRouter from 'vue-router';
import routes from './routes'
import Vue from 'vue';
import Vuesax from 'vuesax';
Vue.use(Vuesax);
import 'vuesax/dist/vuesax.css'
import 'material-icons/iconfont/material-icons.css';



import Skeleton from 'vue-loading-skeleton';
Vue.use(Skeleton)

Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    routes,
})
//</router set up

//third party utils

// </thir party utils

// global component
Vue.component('draggable', draggable);

Vue.component('main-component', require('./components/layouts/MainComponent.vue').default);
Vue.component('auth-component', require('./components/layouts/AuthComponent.vue').default);
Vue.component('navbar-component', require('./components/layouts/NavbarComponent.vue').default);
Vue.component('finance-card-component', require('./components/features/finance/FinanceCardComponent.vue').default);
Vue.component('modal-component', require('./components/materials/ModalComponent.vue').default);
Vue.component('create-content-component', require('./components/materials/CreateContentComponent.vue').default);
Vue.component('card-content-component', require('./components/materials/CardContentComponent.vue').default);
Vue.component('select-filter-component', require('./components/materials/SelectFilterComponent.vue').default);
Vue.component('dropdown-component', require('./components/materials/DropdownComponent.vue').default);
Vue.component('dropdown-icon-component', require('./components/materials/DropdownIconComponent.vue').default);
Vue.component('color-picker-component', require('./components/materials/ColorPickerComponent.vue').default);
Vue.component('chart-component', require('./components/features/finance/ChartComponent.vue').default);
// </global component
// global method

Vue.prototype.$apiConfig = () => {
    if (localStorage.getItem("token")) {
        return {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        }
    } else {
        return false;
    }
}
//</global method

const app = new Vue({
    el: '#app',
    router
});