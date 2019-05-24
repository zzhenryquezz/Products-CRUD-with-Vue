import axios from 'axios';

export default {
    namespaced: true,
    state:{
        productsList: false
    },
    mutations:{
        changeProductsList(state, newProductsList){            
            state.productsList = newProductsList;
        }
    },
    actions:{
        setProductsList({ commit, getters }){
            return new Promise((resolve) => {
                getters.listAllProducts().then(response => {                
                   resolve(commit('changeProductsList', response.data));
                })
            });
        }
    },
    getters:{
        listAllProducts: (state, getters, rootState, rootGetters) => async () => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.get(`${endpoint}products`);
;                return response;
            } catch (error) {
                console.log(JSON.stringify(error))
                return false;
            }
        },
        getProductById: (state, getters, rootState, rootGetters) => async (id) => {
            let endpoint = rootGetters.getEndPointApi;
            console.log(id)
            try {
                let response = await axios.get(`${endpoint}products/${id}`);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        },
        
        addNewProduct: (state, getters, rootState, rootGetters) => async (productData) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.post(`${endpoint}products/add`, productData);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        },
        
        updateProduct: (state, getters, rootState, rootGetters) => async (id, productData) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.put(`${endpoint}products/update/${id}`, productData);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        },
        
        deleteProduct: (state, getters, rootState, rootGetters) => async (id) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.delete(`${endpoint}products/delete/${id}`);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        }
    }
}