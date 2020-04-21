export default {
    namespaced: true,
    state: {
        dataUseOnly: []
    },
    mutations: {
        dataUseOnly(state, data) {
            state.dataUseOnly = data;
        }
    },
    getters: {
        dataUseOnly: state => state.dataUseOnly
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
        }
    }
};
