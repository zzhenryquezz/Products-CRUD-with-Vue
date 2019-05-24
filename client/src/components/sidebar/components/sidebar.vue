<template>
    <v-navigation-drawer
      v-model="computedDrawer"
      fixed
      app
    >
      <v-list dense>
        <v-list-tile exact :to="{ name: 'home' }">
          <v-list-tile-action>
            <v-icon>home</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Home</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'orders-page' }">
          <v-list-tile-action>
            <v-icon>assignment</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Pedidos</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'products-page' }">
          <v-list-tile-action>
            <v-icon>shopping_cart</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Produtos</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    props:{
        drawer:{
            required: true
        }
    },
    computed:{
        computedDrawer: {
            get: function(){
              return  this.drawer;
            },
            set: function(value){
                this.$emit('ChangeDrawer', value)
            }
        }
    },
}
</script>

<style>

</style>
