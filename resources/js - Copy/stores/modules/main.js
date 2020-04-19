import Axios from 'axios'

const state = {
  drawerMain:true,
  User:'',    
  isLoggedIn: !!localStorage.getItem('token'),
  AuthToken: 'Bearer ' + localStorage.getItem('token'),
}

const mutations = {
  
  drawerMain(state){
    state.drawerMain = !state.drawerMain
  },    
  AuthToken (state){
    state.AuthToken = 'Bearer ' + localStorage.getItem('token');
  },
  User(state,data){
    state.User = data
  },
  loginUser (state) {
    state.isLoggedIn = true
  },
  logoutUser (state) {
      state.isLoggedIn = false
      state.profile = {
        name : ''
      }
  },  
}

const getters = {
  drawerMain:state=>state.drawerMain,
  // Auth
  AuthToken:state=>state.AuthToken,
  //
  User:state=>state.User,
  isLoggedIn:state=>state.isLoggedIn,    
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
