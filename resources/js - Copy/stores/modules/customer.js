import Axios from 'axios'

const state = {
    customers:[],
    searchCustomer: '0864735562',
    isLoggedIn: !!localStorage.getItem('token'),
}

const mutations = {
  // Customer
  getCustomers(state,data){
    state.customers = data
  },
  searchCustomer(state,data){
    state.searchCustomer = data
  },    
}

const getters = {
  getCustomers:state=>state.customers,
  searchCustomer:state=>state.searchCustomer,
}

const actions = {

}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
}

