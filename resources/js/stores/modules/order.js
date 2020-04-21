export default {
    namespaced: true,
    state: {
        all: [],
        getByID:{}
    },
    mutations: {
        all(state, data) {
            state.all = data;
        },
        getByID(state, data) {
            state.getByID = data;
        }
    },
    getters: {
        all: state => state.all,
        getByID: state => state.getByID
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
        async getByID({ commit },payload){
            try {
                const response = await axios.get("api/order/"+payload+"/getByID");
                commit('getByID',response.data);
                return response;
            } catch (e) {
                return e;
            }
        }
    }
};
