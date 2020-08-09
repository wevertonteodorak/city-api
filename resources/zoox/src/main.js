import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify';
import axios from 'axios'

//axios.defaults.baseURL = window.location.protocol+"//"+window.location.hostname+"/api"
axios.defaults.baseURL = `${window.location.protocol}//${window.location.host}/api`
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Accept'] = 'application/json'
if (Vue.config.devtools) {
  axios.defaults.baseURL = "http://localhost:8000/api"
}

Vue.prototype.$http = axios;

Vue.config.productionTip = false

new Vue({
  vuetify,
  router,
  render: h => h(App)
}).$mount('#app')
