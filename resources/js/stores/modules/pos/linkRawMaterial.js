export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            return await axios
                .post(`/api/admin/v1/pos/link_raw_material/store`, payload)
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
                    `/api/admin/v1/pos/link_raw_material/${payload.id}/update`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((error) => {
                    return error;
                });
        },
        async remove({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/pos/link_raw_material/${payload.id}/remove`,
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
