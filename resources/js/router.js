import * as VueRouter from 'vue-router';

const routes = [
    {
        path: '/user/registration',
        component: () => import('./Components/User/Registration.vue'),
        name: 'user.registration',
    },
    {
        path: '/user/login',
        component: () => import('./Components/User/Login.vue'),
        name: 'user.login',
    },
];

export default VueRouter.createRouter({
    mode: 'history',
    history: VueRouter.createWebHistory('/'),
    routes,
});
