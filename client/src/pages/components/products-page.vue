<template>
     <v-flex xs12>
        <v-card class="elevation-12">
            <v-toolbar dark color="primary">
                <v-toolbar-title>Products</v-toolbar-title>
                <v-spacer />        
            </v-toolbar>
            <v-card-text>
                <TableProducts />
            </v-card-text>
            <v-card-actions>
            
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
import { TableProducts } from './../../components/products';

export default {
    components:{
        TableProducts
    },
}
</script>

<style>

</style>
