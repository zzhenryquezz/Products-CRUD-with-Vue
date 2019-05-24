<template>
  <v-app id="inspire">
    
    <Sidebar @computedDrawer="(value) => drawer = value" :drawer="drawer" />
    
    <v-toolbar color="indigo" dark fixed app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>Crud Demonstração</v-toolbar-title>
    </v-toolbar>
    
    <v-content>
      
      <router-view></router-view>
        
    </v-content>
    
    <v-footer color="indigo" app>
      <span class="white--text">&copy; {{ date }}</span>
    </v-footer>

  </v-app>
</template>

<script>
import { Sidebar } from './components/sidebar';
export default {
  name: 'Main',
  data(){
    return{
      drawer: null,
      date: new Date().getFullYear()
    }
  },
  components:{
    Sidebar
  },
  props: {
    source: String
  }
}
</script>

<style lang="scss">
  @import './sass/main.scss';
</style>