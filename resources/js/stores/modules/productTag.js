export default {
    namespaced: true,
    state: {
        isProductTags: [],
        data: []
    },
    mutations: {
        data(state, data) {
            state.data = data;
        },
        isProductTags(state, data) {
            state.isProductTags = data;
        }
    },
    getters: {
        data: state => state.data,
        isProductTags: state => state.isProductTags
    },
    actions: {
        async get({ commit }, payload) {
            const response = await axios.get("api/product/tag/" + payload);
            commit("data", response.data);
            return response;
        },
        async store({ dispatch }, payload) {
            const response = await axios.post("api/product/tag/store", payload);            
            dispatch("get",payload.product_id);
            return response;
        },
        async isProductTags({ commit }, payload) {
            const response = await axios.get(
                "api/product/tag/" + payload + "/isProductTags",
                payload
            );
            commit("isProductTags", response.data);
            return response;
        }
    }
};
