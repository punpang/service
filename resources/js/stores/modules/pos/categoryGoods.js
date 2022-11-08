export default {
    namespaced: true,
    state: {
        fetch: [],
    },
    mutations: {
        fetch(state, data) {
            state.fetch = data;
        },
    },
    getters: {
        fetch: (state) => state.fetch,
    },
    actions: {
        async store({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/category_goods/store`, payload)
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
        async fetch({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/pos/category_goods/fetch?${payload}`)
                .then((response) => {
                    commit("fetch", response.data.category_goods);
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
    },
};
