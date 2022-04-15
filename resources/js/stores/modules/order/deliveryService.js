export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/delivery_service/${payload.order_id}/store`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    console.error(error);
                    return error;
                });
        },
        async update({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/delivery_service/${payload.form.id}/update`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    console.error(error);
                    return error;
                });
        },

        async remove({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/delivery_service/${payload.delivery_service_id}/remove`
                )
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    console.error(error);
                    return error;
                });
        },
    },
};
