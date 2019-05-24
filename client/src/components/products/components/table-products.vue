<template>
  <div v-if="computedProducts">
    
    <UpdateProductForm
        @close="showUpdateForm = false; editProduct = false"
        :formTitle="formTitle"
        :editProduct="editProduct"
        @ChangeShowUpdateForm="(value) => showUpdateForm = value"
        :editedItem="editedItem" 
        :showUpdateForm="showUpdateForm" />
    
    <v-data-table
      :headers="headers"
      :items="computedProducts"
      class="elevation-1"
    >
      <template v-slot:items="props">        
        <td class="text-xs-left">{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.description }}</td>
        <td class="text-xs-left">{{ props.item.sku }}</td>
        <td class="text-xs-left">{{ props.item.price }}</td>
        <td class="text-xs-left">
          <v-icon
            small
            class="mr-2"
            @click="editItem(props.item)"
          >
            edit
          </v-icon>
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
import { UpdateProductForm } from './../';
  export default {
    data(){
        return {
            headers: [        
                { text: 'Nome', value: 'name' },
                { text: 'Descrição', value: 'description' },
                { text: 'Estoque', value: 'sku' },
                { text: 'Preço', value: 'price' },    
                { text: 'options', value: 'price', sortable: false },    
            ],
            showUpdateForm: false,
            formTitle: '',            
            products: [],            
            editedItem: null,
            editProduct: false
        }
    },
    components:{
        UpdateProductForm
    },
    created () {
      this.initialize();      
    },
    computed:{
        computedProducts(){
            return this.$store.state.products.productsList;
        }
    },
    methods: {
      async initialize () {
        await this.$store.dispatch('products/setProductsList');                
      },
      editItem (item) {
        this.editProduct = true;     
        this.editedItem = Object.assign({}, item)
        this.showUpdateForm = true
      },
      deleteItem (item) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },
      
    }
  }
</script>