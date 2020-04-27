export default {
    namespaced: true,
    state: {
        all: [],
        getByID: {
            data: {
                id: "",
                customer_id: "",
                dateTime_get: "",
                channel_of_purchase_id: "",
                order_status_id: "",
                permission_to_publish: "",
                token: "",
                created_at: "",
                updated_at: "",
                customer: {
                    id: "",
                    name: "",
                    phone: "",
                    fbid: "",
                    psid: ""
                },
                channel_of_purchase: {
                    id: "",
                    name: "",
                    status: ""
                },
                order_status: {
                    id: "",
                    name: "",
                    style: ""
                },
                order_detail: [],
                payment: []
            },
            sum: {
                total: "",
                deposit: "",
                balance: ""
            },
            count: { product: { use: 0 } }
        },
        selected: {}
    },
    mutations: {
        all(state, data) {
            state.all = data;
        },
        getByID(state, data) {
            state.getByID = data;
        },
        selected(state, data) {
            state.selected = data;
        }
    },
    getters: {
        all: state => state.all,
        getByID: state => state.getByID,
        selected: state => state.selected
    },
    actions: {
        async checkDateTimeForGet({ commit }, payload) {
            try {
                const response = await axios.post(
                    "api/order/checkDateTimeForGet",
                    { dateTime_get: payload }
                );
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async all({ commit }) {
            try {
                const response = await axios.get("api/order/all");
                commit("all", response.data);
            } catch (e) {
                return e;
            }
        },
        async timeGets() {
            try {
                const { data } = await axios.get("api/order/timeGets");
                return data;
            } catch (e) {
                return e;
            }
        },
        async createOrder({}, payload) {
            try {
                const response = await axios.post("api/order/create", payload);
                //dispatch('all');
                return response;
            } catch (e) {
                return e;
            }
        },
        async getByID({ commit }, payload) {
            try {
                const response = await axios.get(
                    "api/order/" + payload + "/getByID"
                );
                commit("getByID", response.data);
                return response;
            } catch (e) {
                return e;
            }
        }
    }
};
