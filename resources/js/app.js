/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from '@/router';
import MainPage from './components/MainPage.vue';


const pinia = createPinia()

const app = createApp({
    components: {
        MainPage,
    }
});

app.use(pinia)
app.use(router);

app.mount('#app');
