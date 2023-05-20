import * as VueRouter from 'vue-router';

const routes = [
    {
        path: '/test',
        component: () => import('./Components/Test.vue'),
        name: 'router.test',
    },
];

export default VueRouter.createRouter({
    mode: 'history',
    history: VueRouter.createWebHistory('/'),
    routes,
});
