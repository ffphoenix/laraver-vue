// Libs import
import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios';
import VueAxios from 'vue-axios';

// Views
import Dashboard from '../modules/dashboard';
import {table as UsersIndex, create as UsersCreate, edit as UsersEdit } from '../modules/users';
import {table as CurrencyIndex, create as CurrencyCreate, edit as CurrencyEdit } from '../modules/currencies';
import {table as CustomerIndex, create as CustomerCreate, edit as CustomerEdit } from '../modules/customers';
import TransactionIndex from '../modules/transactions/table';

// Auth
import Login from '../pages/Login.vue';
import Page404 from '../pages/Page404';

Vue.use(Router)
Vue.use(VueAxios, axios);

export default new Router({
  mode: 'history',
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [

      { path: '/users', name: 'UsersIndex', component: UsersIndex, meta: { auth: true }},
      { path: '/users/create', name: 'UsersCreate', component: UsersCreate, meta: { auth: true }},
      { path: '/users/edit/:id', name: 'UsersEdit', component: UsersEdit, meta: { auth: true }},

      { path: '/currency', name: 'CurrencyIndex', component: CurrencyIndex, meta: { auth: true }},
      { path: '/currency/create', name: 'CurrencyCreate', component: CurrencyCreate, meta: { auth: true }},
      { path: '/currency/edit/:id', name: 'CurrencyEdit', component: CurrencyEdit, meta: { auth: true }},

      { path: '/Customer', name: 'CustomerIndex', component: CustomerIndex, meta: { auth: true }},
      { path: '/Customer/create', name: 'CustomerCreate', component: CustomerCreate, meta: { auth: true }},
      { path: '/Customer/edit/:id', name: 'CustomerEdit', component: CustomerEdit, meta: { auth: true }},

      { path: '/transaction', name: 'TransactionIndex', component: TransactionIndex, meta: { auth: true }},

      { path: '/login', name: 'login', component: Login, meta: { auth: false }},
      { path: '/', redirect: '/users', meta: { auth: false }},
      { path: '*', name: 'Page404', component: Page404, meta: { auth: true }}
  ]
})
