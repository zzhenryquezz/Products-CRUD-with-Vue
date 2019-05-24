import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

const store = new Vuex.Store({    
    getters:{
        getEndPointApi: (state) => {
            let endPoint;
            if(process.env.NODE_ENV === 'production'){
                endPoint = '/api/';
            }else{
                endPoint = 'http://local.projects/api/';
            }
            return endPoint;
        }
    },
    modules:{
        products: require('./modules/products').default,
        orders: require('./modules/orders').default
    },
})

export default store;