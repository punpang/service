import Vue from "vue";
import Vuex from "vuex";
//import Axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        drawerMain: true,
        User: "",
        customers: [],
        searchCustomer: "0864735562",
        orders: [
            {
                id: "3358",
                name: "ไนท์",
                phone: "0928136750",
                status: "ชำระหมด",
                checked: true
            },
            {
                id: "4251",
                name: "แนน",
                phone: "0865281630",
                status: "รอการชำระเงิน",
                checked: false
            }
        ],
        goods: {
            pond: [
                { id: 1, name: "1 ปอนด์", price: 200, priceNormal: 200 },
                { id: 2, name: "2 ปอนด์", price: 350, priceNormal: 400 },
                { id: 3, name: "3 ปอนด์", price: 400, priceNormal: 600 }
            ],
            ontop: [{ id: 1 }]
        },
        isLoggedIn: !!localStorage.getItem("token"),
        profile: {
            name: ""
        },
        AuthToken: "Bearer " + localStorage.getItem("token")
    },
    mutations: {
        drawerMain(state) {
            state.drawerMain = !state.drawerMain;
        },
        AuthToken(state) {
            state.AuthToken = "Bearer " + localStorage.getItem("token");
        },
        User(state, data) {
            state.User = data;
        },
        addOrder(state, form) {
            state.orders.push({
                id: Math.floor(Math.random() * 10000),
                name: form.name,
                phone: form.phone,
                status: "รอการชำระเงิน",
                checked: false
            });
        },
        deleteOrder(state, i) {
            state.orders.splice(i, 1);
        },
        // Customer
        getCustomers(state, data) {
            state.customers = data;
        },
        searchCustomer(state, data) {
            state.searchCustomer = data;
        },

        addCustomer(state, data) {
            state.customers.push({
                id: Math.floor(Math.random() * 100),
                name: data.name,
                phone: data.phone
            });
        },
        deleteCustomer(s, d) {
            s.customers.splice(d, 1);
        },
        loginUser(state) {
            state.isLoggedIn = true;
        },
        logoutUser(state) {
            state.isLoggedIn = false;
            state.profile = {
                name: ""
            };
        }
    },
    getters: {
        drawerMain: state => state.drawerMain,
        // Auth
        AuthToken: state => state.AuthToken,
        //
        User: state => state.User,
        orders: state => state.orders,
        customers: state => state.customers,
        getCustomers: state => state.customers,
        goods: state => state.goods,
        isLoggedIn: state => state.isLoggedIn,
        searchCustomer: state => state.searchCustomer
    },
    actions: {},
    modules: {}
});
