export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            return await axios
                .post("/api/admin/v1/moneyServices/store", payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    return err;
                });
        },
        async update({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/moneyServices/${payload.id}/update`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    return err;
                });
        },

        async delete({}, payload) {
            return await axios
                .post(`/api/admin/v1/moneyServices/${payload.id}/delete`)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    return err;
                });
        },
    },
};
