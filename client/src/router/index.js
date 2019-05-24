import Vue from 'vue';
import VueRouter from 'vue-router';
import {Preloader} from './../preload';

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: Preloader
    },
    {
        path: '/products',
        name: 'products-page',
        component: Preloader
    },
    {
        path: '/orders',
        name: 'orders-page',
        component: Preloader,
        children:[
            {
                path: ':id',
                name: 'single-order',
                component: Preloader
            }
        ]
    }
];
const router = new VueRouter({
    routes
});

export default router;