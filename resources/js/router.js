import * as VueRouter from 'vue-router';

const routes = [
    {
        path: '/user/register',
        component: () => import('./Components/User/Registration.vue'),
        name: 'user.registration',
    },
    {
        path: '/user/login',
        component: () => import('./Components/User/Login.vue'),
        name: 'user.login',
    },
    {
        path: '/user/verify-email',
        component: () => import('./Components/User/VerifyEmail.vue'),
        name: 'user.verify-email'
    },
];

export default VueRouter.createRouter({
    mode: 'history',
    history: VueRouter.createWebHistory('/'),
    routes,
});
