import Vue from 'vue';
import VueRouter from 'vue-router';
import {Preloader} from './../preload';

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: Preloader
    }
];
const router = new VueRouter({
    routes
});

export default router;