<template>   
<v-dialog v-model="computedShowDialog" max-width="500px">
    <template v-slot:activator="{ on }">
        <v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>
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
                <v-text-field required v-model="product.price" label="Preço"></v-text-field>
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
            product:{

            },
            defaultItem: {
                name: '',
                description: '',
                sku: '',
                price: '',
            }
        }
    },
    props:{
        showUpdateForm:{
            type: Boolean,
            required: true,
        },
        formTitle:{
            type: String,
            required: true
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
            }else{
                this.product = this.defaultItem;
            }            
        },
        close () {
            this.newItem = true;                   
            this.$emit('close');
        },
        async save () {
            let product = JSON.parse(JSON.stringify(this.product));
            
            if(this.editProduct){

            }else{
                let response = await this.$store.getters['products/addNewProduct'](product);
                console.log(response);
            }

            this.close();
        }
    }
}
</script>

<style>

</style>
