<template>   
<v-dialog v-model="computedShowDialog" max-width="500px">
    <v-card>
        <v-card-title>
        <span class="headline">{{ formTitle }}</span>
        </v-card-title>

        <v-card-text>
        <v-container grid-list-md>
            <v-layout wrap>            
            <v-flex sm12>
                <h1>Total: R$ {{ total.toString().replace('.', ',') }}</h1>
            </v-flex>            
            <v-flex sm12>
                <v-menu>
                    
                    <v-text-field
                        slot="activator"
                        v-model="order.date"
                        label="Seleciono uma nova data"
                        prepend-icon="event"
                        readonly                        
                    ></v-text-field>
                    
                    <v-date-picker v-model="order.date" no-title scrollable ></v-date-picker>
                </v-menu>
            </v-flex>            
            <v-flex v-if="!computedProducts" sm12>
                <v-alert
                    :value="true"
                    dismissible
                    type="error"
                    >
                    Sem Productos Cadastrados
                </v-alert>
            </v-flex>            
            <v-flex v-if="computedProducts" sm12>
                <v-select
                    v-model="order.products"
                    :items="computedProducts"
                    return-object
                    item-text="name"                    
                    item-value="id"                    
                    label="Selecione os Produtos"
                    multiple
                    chips                    
                    persistent-hint
                    >
                </v-select>
            </v-flex>                            
            
            <v-flex sm12>
        
                <v-alert
                    v-model="error.show"
                    dismissible
                    type="error"
                    >
                    {{ error.message }}
                </v-alert>
            </v-flex>            
            </v-layout>

        </v-container>
        </v-card-text>
        

        <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" flat @click="$emit('close')">Cancel</v-btn>
        <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

</template>

<script>
import moment from 'moment';
export default {
    data(){
        return {
            newItem: true,
            formTitle: '',                        
            search: null,
            error:{
                show: false,
                message: 'error',
            }
        }
    },
    props:{
        showUpdateForm:{
            type: Boolean,
            required: true,
        },
        order:{
            type: Object,
            required: true
        } 
    },
    created() {
        this.setFormValues();
    },
    computed: {
        computedShowDialog:{
            get: function(){            
              return  this.showUpdateForm;
            },
            set: function(value){
                this.$emit('ChangeShowUpdateForm', value)
            }
        },
        computedProducts: function(){            
            return this.$store.state.products.productsList;            
        },
        total: function(){
            let total = 0.00;            
            
            this.order.products.forEach((product) => {
               total = parseFloat(total) + parseFloat(product.price); 
            });
            
            return total;
        }
    },
     watch: {
      'order.products': (val) => {
        if (val.length > 5) {
          this.$nextTick(() => this.model.pop())
        }
      }
    },
    methods:{
        setFormValues(){            
            this.$store.dispatch('products/setProductsList');            
            this.formTitle = 'Editar Pedido';                        
        },        
        async save () {
            let order = JSON.parse(JSON.stringify(this.order));            
            order.date = moment(order.date).format('YYYY-MM-DDTHH:mm:ss');            
            order.total = this.total;            
            let response = await this.$store.getters['orders/updateOrder'](order.id, order);
            
            if(!response){                
                this.error.show = true;
                this.error.message = 'Sinto muito ouve um erro';
                return;
            }
            
            await this.$store.dispatch('orders/setOrdersList');
            this.close();
        },
        close () {
            this.newItem = true;                   
            this.$emit('close');
        },
    }
}
</script>

<style>

</style>
