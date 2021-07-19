export default {
    namespaced: true,
    state: {
        self: {},
        sumQuantity: 0
    },
    mutations: {
        self(state, data) {
            state.self = data;
        },
        sumQuantity(state, data) {
            state.sumQuantity = data;
        }
    },
    getters: {
        self: state => state.self,
        sumQuantity: state => state.sumQuantity
    },
    actions: {
        async self({ commit }) {
            commit("self", {});
            const res = await axios.get("/api/kitchen/self");
            commit("self", res.data.data);
            commit("sumQuantity", res.data.sumQuantity);
        }
    }
};
