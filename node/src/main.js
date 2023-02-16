import { createApp } from 'vue'
//import Vuex from 'vuex'
//import axios from 'axios'
import store from './store';
import api from './api';
import router from './router'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import App from './App.vue'

const vue = createApp(App);

vue.use(router);
vue.use(store);

vue.config.globalProperties.$http = api

vue.mount('#app');