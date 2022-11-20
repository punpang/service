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
                .post(`/api/admin/v1/tags/store`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((error) => {
                    return error;
                });
        },
        async edit_tag({}, payload) {
            return await axios
                .post(`/api/admin/v1/tags/${payload.id}/edit_tag`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((error) => {
                    return error;
                });
        },
        async tags_store({}, payload) {
            return await axios
                .post(`/api/admin/v1/tags/tags_store`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((error) => {
                    return error;
                });
        },

        async fetch({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/tags/fetch?${payload}`)
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
