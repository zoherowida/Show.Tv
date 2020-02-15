
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';

Vue.use(VueAxios, axios);

import LoginComponent from './components/LoginComponent.vue';
import HomeComponent from './components/HomeComponent.vue';
import EpisodeComponent from './components/EpisodeComponent.vue';
import SeriesTvComponent from './components/SeriesTvComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import NotFoundComponent from './components/NotFoundComponent.vue';
const routes = [
    {
        path: '/',
        component: HomeComponent,
    },
    {
        name: 'home',
        path: '/home',
        component: HomeComponent,
    },
    {
        name: 'login',
        path: '/login',
        component: LoginComponent
    },
    {
        name: 'register',
        path: '/register',
        component: RegisterComponent
    },
    {
        name: 'episode',
        path: '/episode/:id',
        component: EpisodeComponent,
    },
    {
        name: 'Series',
        path: '/SeriesTv/:id',
        component: SeriesTvComponent,

    },
    {
        name: 'Notfound',
        path: "*",
        component: NotFoundComponent,
    }

];


const router = new VueRouter({ mode: 'history', routes: routes});

router.beforeEach((to, from, next) => {
    if (to.name) {
        // Start the route progress bar.
        NProgress.start()
    }

    if(to.matched.some(rec => rec.meta.requiresAuth)){
        const authUser = localStorage.getItem('user');
        if(authUser){
            next()
        }else{
            next('/login')
        }
    }
    next()
});
router.afterEach((to, from, next) => {
    NProgress.done()

});

const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');
