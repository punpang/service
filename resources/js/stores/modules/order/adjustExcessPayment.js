export default {
    namespaced: true,
    state: {
        fetchChannels: [],
    },
    mutations: {
        fetchChannels(state, data) {
            state.fetchChannels = data;
        },
    },
    getters: {
        fetchChannels: (state) => state.fetchChannels,
    },
    actions: {
        async fetchChannels({ commit }) {
            return await axios
                .get(`/api/admin/v1/adjustExcessPayment/fetchChannels`)
                .then((response) => {
                    commit("fetchChannels", response.data.data);
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
        async store({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/adjustExcessPayment/order/${payload.order.id}/store`,
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
