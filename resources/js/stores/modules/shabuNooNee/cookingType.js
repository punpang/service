export default {
    namespaced: true,
    state: {
        self: {}
    },
    mutations: {
        self(state, data) {
            state.self = data;
        }
    },
    getters: {
        self: state => state.self
    },
    actions: {
        async self({ commit }) {
            commit("self", {});
            await axios.get("/api/cashier/cookingType").then(response => {
                commit("self", response.data);
            });
        }
    }
};
