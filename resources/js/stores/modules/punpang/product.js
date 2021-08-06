export default {
    namespaced: true,
    state: {
        fetchAllUse: []
    },
    mutations: {
        fetchAllUse(state, data) {
            state.fetchAllUse = data;
        }
    },
    getters: {
        fetchAllUse: state => state.fetchAllUse
    },
    actions: {
        async fetchAllUse({ commit }) {
            commit("fetchAllUse", []);
            const res = await axios.get(
                "/api/v1/guest/product/punpang/fetchAllUse"
            );
            commit("fetchAllUse", res.data);
            
        }
    }
};
