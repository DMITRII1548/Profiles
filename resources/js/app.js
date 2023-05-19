import './bootstrap';
import '../css/app.css'
import { createApp, VueElement } from "vue/dist/vue.esm-bundler";
import AppComponent from './components/App.vue';

const app = createApp({
    components: {
        AppComponent,
    }
});

app.mount('#app');
