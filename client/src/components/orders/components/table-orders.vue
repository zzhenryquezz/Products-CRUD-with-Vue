<template>
  <div v-if="computedOrders">
    
    <UpdateOrderForm
        @close="showUpdateForm = false; editOrder = false"        
        @ChangeShowUpdateForm="(value) => {showUpdateForm = value;editOrder = false}"        
        :showUpdateForm="showUpdateForm" />
    
    <v-data-table
      :headers="headers"
      :items="computedOrders"
      rows-per-page-text="Produtos por pagina"
      class="elevation-1"
    >
      <template v-slot:items="props">        
        <td class="text-xs-left">{{ props.item.date }}</td>
        <td class="text-xs-left">{{ props.item.products.length }}</td>        
        <td class="text-xs-left">R$ {{ props.item.total.replace('.', ',') }}</td>        
        <td class="text-xs-left">
          
          <v-btn icon small
            class="mr-2"
            :to="{name:'single-order', params:{ id: props.item.id}}"
          >
            <v-icon small>edit</v-icon>
          </v-btn>

          <v-icon
            small
            @click="deleteItem(props.item)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import { UpdateOrderForm } from './../';
  export default {
    data(){
        return {
            headers: [                        
                { text: 'Data', value: 'date' },
                { text: 'Qtn de Produtos', value: 'products' },
                { text: 'Total', value: 'total' },    
                { text: 'options', value: 'price', sortable: false },    
            ],
            showUpdateForm: false,
            formTitle: '',                        
            editedItem: null,
            editOrder: false
        }
    },
    components:{
        UpdateOrderForm
    },
    created () {
      this.initialize();      
    },
    computed:{
        computedOrders(){
            return this.$store.state.orders.ordersList;
        }
    },
    methods: {
      async initialize () {
        await this.$store.dispatch('orders/setOrdersList');              
      },
      editItem (item) {
        this.editOrder = true;     
        this.editedItem = Object.assign({}, item)
        this.showUpdateForm = true
      },
      async deleteItem (order) {
        let answer = confirm('Are you sure you want to delete this item?');
        if(answer == true){
          await this.$store.getters['orders/deleteOrders'](product.id);
          await this.$store.dispatch('orders/setOrdersList');
          alert('order delete')
        }
      },
      
    }
  }
</script>