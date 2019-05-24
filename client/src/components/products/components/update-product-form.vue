<template>   
<v-dialog v-model="computedShowDialog" max-width="500px">
    <template  v-slot:activator="{ on }">
        <v-flex class="text-xs-right" xs12>
            <v-btn color="primary" dark class="mb-2" v-on="on">Adicionar Produto</v-btn>
        </v-flex>
    </template>
    <v-card>
        <v-card-title>
        <span class="headline">{{ formTitle }}</span>
        </v-card-title>

        <v-card-text>
        <v-container grid-list-md>
            <v-layout wrap>
            <v-flex xs12 sm6 md6>
                <v-text-field required v-model="product.name" label="Product name"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md6>
                <v-text-field v-model="product.description" label="Descrição"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md6>
                <v-text-field required type="number" min="0" v-model="product.sku" label="Estoque"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md6>
                <v-text-field required step=".01" prefix="R$" type="number" v-model="product.price" label="Preço"></v-text-field>
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
export default {
    data(){
        return {
            newItem: true,
            formTitle: '',
            product:{

            },
            defaultItem: {
                name: '',
                description: '',
                sku: '',
                price: '',
            },
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
        editProduct:{
            type: Boolean,
            required: false
        },
        editedItem:{
            type: Object,
            required: false,
        },
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
    },
    watch: {
        editProduct: 'setFormValues'
    },
    methods:{
        setFormValues(){
            if(this.editProduct){
                this.product = this.editedItem;
                this.formTitle = 'Editar Produto';
            }else{
                this.product = this.defaultItem;
                this.formTitle = 'Adicionar Produto';
            }            
        },        
        async save () {
            let product = JSON.parse(JSON.stringify(this.product));
            let response;
            if(this.editProduct){
                response = await this.$store.getters['products/updateProduct'](product.id,product);
            }else{
                response = await this.$store.getters['products/addNewProduct'](product);                
            }
            
            if(!response){                
                this.error.show = true;
                this.error.message = 'Sinto muito ouve um erro';
                return;
            }
            
            await this.$store.dispatch('products/setProductsList');
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
