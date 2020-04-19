import Vue from 'vue'
import Vuex from 'vuex'
import main from'./modules/main.js';
import customer from'./modules/customer.js';

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: true,
    modules: {
        main,
        customer
    }
})