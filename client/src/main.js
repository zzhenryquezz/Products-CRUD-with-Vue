import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

new Vue({
  store: require('./store').default,
  router: require('./router').default,
  render: h => h(App),
}).$mount('#app')
