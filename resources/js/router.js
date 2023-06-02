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
    {
        path: '/user/dashboard',
        component: () => import('./Components/User/Dashboard.vue'),
        name: 'user.dashboard',
    },
    {
        path: '/user/forgot-password',
        component: () => import('./Components/User/ForgotPassword.vue'),
        name: 'user.forgot-password',
    },
    {
        path: '/user/reset-password/:token',
        component: () => import('./Components/User/ResetPassword.vue'),
        name: 'user.reset-password',
    },
];

const router =  VueRouter.createRouter({
    mode: 'history',
    history: VueRouter.createWebHistory('/'),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')

    if (!token) {
        if (to.name === 'user.login') {
            return next()
        } else if (to.name === 'user.registration') {
            return next()
        } else if (to.name === 'user.forgot-password') {
            return next()
        } else if (to.name === 'user.reset-password') {
            return next()
        } else {
            return next({ name: 'user.login' })
        }
    }

    next()

})

export default router

