import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
      endPoint: 0
    },
    mutations:{
        changeEndpointApi(state, newEndpoint){
            state.endPoint = newEndpoint;
        }
    },
    actions:{
        setEndpointApi ({ commit, getters }){
            let endPoint = getters.getEndPointApi;
            commit('changeEndpointApi', endPoint);
        }
    },
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
    }
})

export default store;