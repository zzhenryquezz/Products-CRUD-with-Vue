import Vue from 'vue'
import './plugins/vuetify'
import App from './App.vue'
import Vuetify from 'vuetify';

Vue.config.productionTip = false

Vue.use(Vuetify);

new Vue({
  store: require('./store').default,
  router: require('./router').default,
  render: h => h(App),
}).$mount('#app')
