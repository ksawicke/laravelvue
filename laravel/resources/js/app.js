
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true

import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import CompaniesIndex from './components/companies/CompaniesIndex.vue';
// import PlayersCreate from './components/players/PlayersCreate.vue';
// import PlayersEdit from './components/players/PlayersEdit.vue';
//
// import TeamsIndex from './components/teams/TeamsIndex.vue';
// import TeamsCreate from './components/teams/TeamsCreate.vue';
// import TeamsEdit from './components/teams/TeamsEdit.vue';

const routes = [
    // PLAYERS
    {
        path: '/admin/companies',
        components: {
            companiesIndex: CompaniesIndex
        }
    },
    // {
    //     path: '/admin/players/create',
    //     component: PlayersCreate,
    //     name: 'createPlayer'
    // },
    // {
    //     path: '/admin/players/edit/:id',
    //     component: PlayersEdit,
    //     name: 'editPlayer'
    // },
    //
    // // TEAMS
    // {
    //     path: '/admin/teams',
    //     components: {
    //         teamsIndex: TeamsIndex
    //     }
    // },
    // {
    //     path: '/admin/teams/create',
    //     component: TeamsCreate,
    //     name: 'createTeam'
    // },
    // {
    //     path: '/admin/teams/edit/:id',
    //     component: TeamsEdit,
    //     name: 'editTeam'
    // }
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')
