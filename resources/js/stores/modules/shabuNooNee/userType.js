export default {
    namespaced: true,
    state: {
        nextTo: []
    },
    mutations: {
        nextTo(state, data) {
            state.nextTo = data;
        }
    },
    getters: {
        nextTo: state => state.nextTo
    },
    actions: {
        async nextTo({ commit }) {
            commit("nextTo", {});
            const res = await axios.get("/api/admin/userType/nextTo");
            commit("nextTo", res.data.data);
        }
    }
};
