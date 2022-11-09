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
        async update({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/goods/${payload.id}/update`, payload)
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },

        async fetch({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/pos/goods/fetch?${payload}`)
                .then((response) => {
                    commit("fetch", response.data.goods);
                    return response.data;
                })
                .catch((error) => {
                    return error;
                });
        },
        async updateStatusUse({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/goods/${payload.id}/updateStatusUse`)
                .then((response) => {
                    return response.data;
                })
                .catch((error) => {
                    return error;
                });
        },
    },
};
