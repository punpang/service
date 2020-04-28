export default {
    namespaced: true,
    state: {
        all: [],
        useonly:[]
    },
    mutations: {
        all(state, data) {
            state.all = data;
        },
        useonly(state, data) {
            state.useonly = data;
        }
    },
    getters: {
        all: state => state.all,
        useonly: state => state.useonly,
    },
    actions: {
        async all({ commit }) {
            const res = await axios.get("/api/payment/method/all");
            commit("all", res.data);
        },
        async useonly({ commit }) {
            const res = await axios.get("/api/payment/method/useonly");
            commit("useonly", res.data);
        },
    }
};
