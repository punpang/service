export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/order/store`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    return err;
                });
        },

        async update({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/order/${payload.id}/update`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    return err;
                });
        },

        async delete({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/order/${payload.id}/delete`, payload)
                .then((response) => {
                    return response.data;
                })
                .catch((err) => {
                    return err;
                });
        },
    },
};
