import axios from 'axios';

export default {
    namespaced: true,
    state:{
        ordersList: false
    },
    mutations:{
        changeOrdersList(state, newOrdersLists){            
            state.ordersList = newOrdersLists;
        }
    },
    actions:{
        setOrdersList({ commit, getters }){
            return new Promise((resolve) => {
                getters.listAllOrders().then(response => {                        
                   resolve(commit('changeOrdersList', response.data));
                })
            });
        }
    },
    getters:{
        listAllOrders: (state, getters, rootState, rootGetters) => async () => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.get(`${endpoint}orders`);                
;                return response;
            } catch (error) {
                console.log(JSON.stringify(error))
                return false;
            }
        },
        getOrderById: (state, getters, rootState, rootGetters) => async (id) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.get(`${endpoint}orders/${id}`);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        },
        
        addNewOrder: (state, getters, rootState, rootGetters) => async (orderData) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.post(`${endpoint}orders/add`, orderData);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        },
        
        updateOrder: (state, getters, rootState, rootGetters) => async (id, orderData) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.put(`${endpoint}orders/update/${id}`, orderData);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        },
        
        deleteOrder: (state, getters, rootState, rootGetters) => async (id) => {
            let endpoint = rootGetters.getEndPointApi;
            try {
                let response = await axios.delete(`${endpoint}orders/delete/${id}`);
;                return response;
            } catch (error) {
                console.log(error)
                return false;
            }
        }
    }
}