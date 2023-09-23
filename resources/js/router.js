import * as VueRouter from 'vue-router'

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
    {
        path: '/user/edit',
        component: () => import('./Components/User/Edit.vue'),
        name: 'user.edit',
    },
    {
        path: '/profile/show',
        component: () => import('./Components/Profile/CurrentUserShow.vue'),
        name: 'authUserProfile.show',
    },
    {
        path: '/profile/:id',
        component: () => import('./Components/Profile/Show.vue'),
        name: 'profile.show',
    },
    {
        path: '/profile/create',
        component: () => import('./Components/Profile/Create.vue'),
        name: 'profile.create',
    },
    {
        path: '/profile/edit',
        component: () => import('./Components/Profile/Edit.vue'),
        name: 'profile.edit',
    },

]

const router =  VueRouter.createRouter({
    mode: 'history',
    history: VueRouter.createWebHistory('/'),
    routes,
})

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
    } else {
        if (to.name === 'user.login') {
            return next({ name: 'user.dashboard' })
        } else if (to.name === 'user.registration') {
            return next({ name: 'user.dashboard' })
        } else if (to.name === 'user.forgot-password') {
            return next({ name: 'user.dashboard' })
        } else if (to.name === 'user.reset-password') {
            return next({ name: 'user.dashboard' })
        } else {
            return next()
        }
    }

})

export default router

