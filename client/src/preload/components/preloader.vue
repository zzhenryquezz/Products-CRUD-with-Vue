<template>
    <v-container fluid fill-height>
        <v-layout
          justify-center
          align-center
        >
            <ProductsPage v-if="postType == 'products'" />
            
            <OrdersPage v-else-if="postType == 'orders'" />
            
            <HomePage v-else-if="postType == 'home'" />
            
            <HomePage v-else />
        
        </v-layout>
    </v-container>
</template>

<script>

import { ProductsPage, HomePage, OrdersPage } from './../../pages';

export default {
    computed: {
        postType: function(){
            switch (this.$route.name) {
                case 'home':
                    return 'home'
                break;
                
                case 'products-page':
                    return 'products'
                break;
                
                case 'orders-page':
                    return 'orders'
                break;
            
                default:
                    return 'home'
                break;
            }
        }
    },
    components:{
        ProductsPage,
        HomePage,
        OrdersPage
    }
}
</script>

<style>

</style>
