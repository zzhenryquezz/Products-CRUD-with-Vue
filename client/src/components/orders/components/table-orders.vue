<template>
  <div v-if="computedOrders">
    
    <AddNewOrderForm
        @close="showAddForm = false; editOrder = false"        
        @ChangeShowUpdateForm="(value) => {showAddForm = value;}"
        :showAddForm="showAddForm" />
    
    <UpdateOrderForm
        @close="showUpdateForm = false; editOrder = false"        
        @ChangeShowUpdateForm="(value) => showUpdateForm = value"
        :order="editedItem"
        :showUpdateForm="showUpdateForm" />
    
    <v-data-table
      :headers="headers"
      :items="computedOrders"
      :expand="expand"
      rows-per-page-text="Pedidos por pagina"
      class="elevation-1"
    >
      <template v-slot:items="props">
        <tr>
          <td class="text-xs-left">{{ moment(props.item.date).format('DD/MM/YYYY') }}</td>
          <td class="text-xs-left">{{ props.item.products.length }}</td>        
          <td class="text-xs-left">R$ {{ props.item.total.replace('.', ',') }}</td>        
          <td class="text-xs-left">          
            
            <v-btn icon small
              class="mr-2"
              @click="props.expanded = !props.expanded"
            >
              <v-icon small>visibility</v-icon>
            </v-btn>

            <v-btn icon small
              class="mr-2"
              @click="editItem(props.item)"
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
        </tr>     
      </template>
      <template v-slot:expand="props">
        <v-data-iterator
          class="px-4 pt-4"
          :items="props.item.products"      
          content-tag="v-layout"
          rows-per-page-text="Produtos por pagina"
          row
          wrap
        >
      <template v-slot:item="props">
        <v-flex
          xs12
          sm6
          md4
          lg3
        >
          <v-card class="mr-3">
            <v-card-title><h4>{{ props.item.name }}</h4></v-card-title>
            <v-divider></v-divider>
            <v-list dense>              
            
              <v-list-tile>
                <v-list-tile-content>Preço:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.price }}</v-list-tile-content>
              </v-list-tile>              
              <v-list-tile>
                <v-list-tile-content>Descrição:</v-list-tile-content>
                <v-list-tile-content class="align-end">{{ props.item.description }}</v-list-tile-content>
              </v-list-tile>              
            
            </v-list>
          </v-card>
        </v-flex>
      </template>
    </v-data-iterator>
      </template>

      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import { UpdateOrderForm, AddNewOrderForm } from './../';
import moment from 'moment';
  export default {
    data(){
        return {
            headers: [                        
                { text: 'Data', value: 'date' },
                { text: 'Qtn de Produtos', value: 'products' },
                { text: 'Total', value: 'total' },    
                { text: 'options', value: 'price', sortable: false },    
            ],
            moment,
            showAddForm: false,
            showUpdateForm: false,
            formTitle: '',                        
            editedItem: {
              products:[]
            },
            expand: false,
            
        }
    },
    components:{
        UpdateOrderForm,
        AddNewOrderForm
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
      editItem (order) {         
        this.editedItem = Object.assign({}, order);
        this.editedItem.date = moment(this.editedItem.date).format('YYYY-MM-DD');
        
        this.showUpdateForm = true
      },
      async deleteItem (order) {
        let answer = confirm('Tem certeza que quer exluir este item?');
        if(answer == true){
          await this.$store.getters['orders/deleteOrder'](order.id);
          await this.$store.dispatch('orders/setOrdersList');
          alert('Pedido Excluido');
        }
      },
      
    }
  }
</script>