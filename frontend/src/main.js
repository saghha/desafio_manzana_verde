window.axios = require('axios');
window._ = require('lodash');

import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from './store/index'
import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.prototype.$log = console.log.bind(console)
Vue.use(VueSweetalert2);
Vue.use(VueFormWizard)
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('v-select', vSelect)
Object.keys(rules).forEach(rule => {
  extend(rule, rules[rule]);
});

axios.defaults.baseURL = process.env.VUE_APP_API_ENDPOINT
console.log(process.env.VUE_APP_API_ENDPOINT)

router.beforeEach((to, from, next) => {
  store.dispatch('authenticate').then(() => {
    axios.defaults.headers.common = {
      'X-Requested-With': 'XMLHttpRequest',
      'Authorization': 'Bearer ' + store.getters.token
    }
    if(!to.matched.some(record => record.meta.requiresAuth)){
      next()
    }
    else {
      next()
    }
  }).catch((err) =>{
    if(to.matched.some(record => record.meta.requiresAuth)){
      next('/auth/login')
    } else {
      next()
    }
  })
})

new Vue({
  el: '#app',
  router,
  store,
  icons,
  template: '<App/>',
  components: {
    App
  }
})
