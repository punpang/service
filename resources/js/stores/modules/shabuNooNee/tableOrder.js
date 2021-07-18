export default {
    namespaced: true,
    state: {
        self: {},
        productGroupAllow: []
    },
    mutations: {
        self(state, data) {
            state.self = data;
        },
        productGroupAllow(state, data) {
            state.productGroupAllow = data;
        }
    },
    getters: {
        self: state => state.self,
        productGroupAllow: state => state.productGroupAllow
    },
    actions: {
        async self({ commit }) {
            commit("self", {});
            const res = await axios.get("/api/tableOrder/self");
            commit("self", res.data.data);
        },
        async selfUUID({ commit, dispatch }, payload) {
            commit("self", {});
            const res = await axios.post("/api/tableOrder/selfUUID", payload);
            commit("self", res.data.data);
            dispatch(
                "productGroupAllow",
                res.data.data.price_range.product_group_allow
            );
        },
        async productGroupAllow({ commit }, payload) {
            commit("productGroupAllow", {});
            const res = await axios.post("/api/tableOrder/productGroupAllow", {
                productGroupAllow: payload
            });
            commit("productGroupAllow", res.data.data);
        },
        async store({}, payload) {
            const res = await axios.post("/api/tableOrder/store", payload);
            return res;
        }
    }
};
