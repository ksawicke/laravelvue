
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'

Vue.use(VueRouter)
Vue.use(BootstrapVue)

import App from './components/App'
import Hello from './components/Hello'
import Home from './components/Home'
import UsersIndex from './components/UsersIndex';
import CompaniesIndex from './components/CompaniesIndex';
import StatusesIndex from './components/StatusesIndex';
import StatusesCreate from './components/StatusesCreate';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello
        },
        {
            path: '/users',
            name: 'users.index',
            component: UsersIndex
        },
        {
            path: '/companies',
            name: 'companies.index',
            component: CompaniesIndex
        },
        {
            path: '/statuses',
            name: 'statuses.index',
            component: StatusesIndex
        },
        {
            path: '/statuses/create',
            name: 'statuses.create',
            component: StatusesCreate
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
