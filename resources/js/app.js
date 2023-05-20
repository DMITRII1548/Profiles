import './bootstrap';
import '../css/app.css'
import { createApp, VueElement } from "vue/dist/vue.esm-bundler";
import AppComponent from './components/App.vue';
import router from './router';

const app = createApp({
    components: {
        AppComponent,
    }
});

app.use(router);

app.mount('#app');
