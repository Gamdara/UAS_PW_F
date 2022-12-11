import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import vuetify from '@/plugins/vuetify'
// import 'bootstrap/dist/css/bootstrap.min.css'
import 'vue-navigation-bar/dist/vue-navigation-bar.css'
import VueNavigationBar from 'vue-navigation-bar'
import '@mdi/font/css/materialdesignicons.css'
import { BootstrapVue, IconsPlugin, NavbarPlugin } from 'bootstrap-vue'

// Import Bootstrap and BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(NavbarPlugin)

Vue.component('vue-navigation-bar', VueNavigationBar)

Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
