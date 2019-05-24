<template>
     <v-flex xs12 class="text-xs-center">
        <v-card class="elevation-12">
            <v-toolbar dark color="primary">
                <v-toolbar-title>Home</v-toolbar-title>
                <v-spacer />        
            </v-toolbar>
            <v-card-text>
                <v-btn                    
                    color="primary"
                    class="white--text"
                    large                  
                    :to="{name:'products-page'}"
                >
                    <v-icon left dark>shopping_cart</v-icon>
                    Produtos
                </v-btn>
                
                <v-btn                    
                    color="primary"
                    class="white--text"
                    large                  
                    :to="{name:'orders-page'}"
                >
                    <v-icon left dark>assignment</v-icon>
                    Pedidos
                </v-btn>

            </v-card-text>            
        </v-card>
    </v-flex>
</template>

<script>
export default {

}
</script>

<style>

</style>
