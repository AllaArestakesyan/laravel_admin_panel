import { createPinia } from 'pinia';
import { createApp } from "vue";
import './bootstrap';

import AppComponent from './App.vue';
import router from './router';
import store from './store'
import messages from './locales'

import { createI18n } from 'vue-i18n'


const script = document.createElement('script');
script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyDFMTVCOGHXaWQGdJ46_LVwiSGwkqvbJME&libraries=places`;
script.async = true;
document.head.appendChild(script);

script.onload = () => {
  console.log("Google Maps API");
};


const savedLocale = localStorage.getItem('locale') || 'en'

const i18n = createI18n({
  locale: savedLocale,
  fallbackLocale: 'en',
  messages,
})

const app = createApp({});
const pinia = createPinia()

app.component("app-component", AppComponent);

app.use(pinia)
app.use(i18n)
app.use(router)
app.use(store)

app.mount("#app");