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
        async fetch({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/pos/raw_material/fetch?${payload}`)
                .then((response) => {
                    commit("fetch", response.data.raw_materials);
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
        async store({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/raw_material/store`, payload)
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
        async update({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/pos/raw_material/${payload.id}/update`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
    },
};
