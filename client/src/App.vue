<template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">
     <router-view></router-view>    
  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'
import axios from 'axios';
export default {
  name: 'app',
  components: {
    HelloWorld
  },
  async created(){
    this.$store.dispatch('setEndpointApi');
    let endpoint = this.$store.state.endPoint;
    console.log(endpoint);
    let response = await axios.get(`${endpoint}/orders`);
    console.log(response);
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
