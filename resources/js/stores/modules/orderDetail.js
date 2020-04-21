export default {
    namespaced: true,
    state: {
        dataUseOnly: [],
        getByOrderId: []
    },
    mutations: {
        dataUseOnly(state, data) {
            state.dataUseOnly = data;
        },
        getByOrderId(state, data) {
            state.getByOrderId = data;
        }
    },
    getters: {
        dataUseOnly: state => state.dataUseOnly,
        getByOrderId: state => state.getByOrderId
    },
    actions: {
        async store({ dispatch }, payload) {
            const res = await axios.post("api/order/detail/store", payload);
            dispatch("dataUseOnly");
            return res;
        },
        async UseOnly({ commit }, payload) {
            const response = await axios.post(
                "api/order/detail/" + payload + "useonly"
            );
            commit("dataUseOnly", response.data);
        },
        async getByOrderID({ commit }, payload) {
            const response = await axios.get(
                "api/order/detail/" + payload + "/getByOrderID"
            );
            commit("getByOrderId", response.data);
        }
    }
};
