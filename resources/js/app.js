import { createPinia } from 'pinia';
import { createApp } from "vue";
import './bootstrap';

import AppComponent from './App.vue';
import router from './router';
import store from './store'

const app = createApp({});
const pinia = createPinia()

app.component("app-component", AppComponent);

app.use(pinia)
app.use(router)
app.use(store)

app.mount("#app");