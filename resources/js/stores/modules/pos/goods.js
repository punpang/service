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
                .post(`/api/admin/v1/pos/goods/store`, payload)
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },

        async fetch({ commit }, payload) {
            console.log("fhdsauio");
            return await axios
                .get(`/api/admin/v1/pos/goods/fetch?${payload}`)
                .then((response) => {
                    commit("fetch", response.data);
                    return response.data;
                })
                .catch((error) => {
                    return error;
                });
        },
    },
};
