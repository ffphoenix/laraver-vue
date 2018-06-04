$(document).ready(function($){
    /**
     * First we will load all of this project's JavaScript dependencies which
     * includes Vue and other libraries. It is a great starting point when
     * building robust, powerful web applications using Vue and Laravel.
     */

    require('./bootstrap');

    window.Vue = require('vue');
    import VueRouter from 'vue-router';

    window.Vue.use(VueRouter);

    import CompaniesIndex from './components/users/index.vue';

    var routes = [
        {
            path: '/',
            components: {
                companiesIndex: CompaniesIndex
            }
        },
    ]

    var router = new VueRouter({ routes })

    var app = new Vue({ router }).$mount('#table tbody')

});