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
                .post(`/api/admin/v1/sms/messages/store`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    console.error(err);
                    return err;
                });
        },
        async update({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/sms/messages/${payload.sms.id}/update`,
                    payload
                )
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    console.error(err);
                    return err;
                });
        },
        async fetch({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/sms/messages/fetch?${payload}`)
                .then((response) => {
                    commit("fetch", response.data.fetch);
                    return response.data;
                })
                .catch((err) => {
                    console.error(err);
                    return err;
                });
        },
        async send({}, payload) {
            return await axios
                .post(`/api/admin/v1/sms/messages/send`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    console.error(err);
                    return err;
                });
        },
    },
};
