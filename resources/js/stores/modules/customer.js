export default {
    namespaced: true,
    state: {
        customers: [],
        selectCustomerByPhone: {},
        phoneOnly:[],
        selectCustomerInGetForOrder:{}
    },
    mutations: {
        // Customer
        getCustomers(state, data) {
            state.customers = data;
        },
        addCustomer(state, data) {
            state.customers.push(data);
        },
        editCustomer(state, data) {
            state.customers.splice(data, 1);
            state.customers.push(data);
        },
        getPhoneOnly(state,data){
            state.phoneOnly = data
        },
        selectCustomerByPhone(state,data){
            state.selectCustomerByPhone = data
        },
        selectCustomerInGetForOrder(state,data){
            state.selectCustomerInGetForOrder = data
        }
    },
    getters: {
        getCustomers: state => state.customers,
        getPhoneOnly: state => state.phoneOnly,
        selectCustomerByPhone: state => state.selectCustomerByPhone,
        selectCustomerInGetForOrder: state =>state.selectCustomerInGetForOrder,
    },
    actions: {
        async get({ commit }) {
            try {
                const response = await axios.get("/api/customer");
                commit("getCustomers", response.data);
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async add({ commit }, payload) {
            try {
                const response = await axios.post(
                    "/api/customer/store",
                    payload
                );
                commit("addCustomer", response.data);
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async edit({ dispatch }, payload) {
            try {
                const response = await axios.post(
                    "/api/customer/" + payload.id + "/edit",
                    payload
                );
                dispatch("get");
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async getPhoneOnly({ commit }) {
            try {
                const response = await axios.get("/api/customer/phoneOnly");
                commit("getPhoneOnly", response.data);
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async selectCustomerByPhone({ commit },payload) {
            try {
                const response = await axios.get("/api/customer/" + payload + "/selectCustomerByPhone");
                commit("selectCustomerByPhone", response.data);
                return response;
            } catch ({ response }) {
                return response;
            }
        },
    }
};
