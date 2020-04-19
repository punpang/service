export default {
    namespaced: true,
    state: {
        all: []
    },
    mutations: {
        all(state, data) {
            state.all = data;
        }
    },
    getters: {
        all: state => state.all
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
        }
    }
};
