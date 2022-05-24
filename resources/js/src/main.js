import Vue from 'vue'
import { ToastPlugin, ModalPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'
import axios from 'axios'
// import VueAxios from 'vue-axios'

import router from './router'
import store from './store'
import App from './App.vue'

// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://127.0.0.1:8000/api/";
// axios.defaults.headers.post['Content-Type'] = 'application/json;'

axios.interceptors.request.use(function (config) {
    const accessToken = localStorage.getItem('accessToken');
    config.headers.Authorization =  accessToken;

    return config;
});

axios.interceptors.response.use(undefined, function(error) {
  if (error) {
    const originalRequest = error.config;
    if (error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      store.dispatch("logout");
      return router.push("/login");
    }
  }
});


// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)

// Composition API
Vue.use(VueCompositionAPI)

// import core styles
require('@resources/scss/core.scss')

// import assets styles
require('@resources/assets/scss/style.scss')

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
