<template>
     <v-flex xs12>
        <v-card class="elevation-12">
            <v-toolbar dark color="primary">
                <v-toolbar-title>orders</v-toolbar-title>
                <v-spacer />        
            </v-toolbar>
            <v-card-text>
            <TableOrders />
            </v-card-text>
            <v-card-actions>
            
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
import { TableOrders } from './../../components/orders';
export default {
    components:{
        TableOrders
    }
}
</script>

<style>

</style>
