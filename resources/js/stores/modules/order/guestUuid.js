export default {
    namespaced: true,
    state: {
        getByUUID: {},
    },
    mutations: {
        getByUUID(state, data) {
            state.getByUUID = data;
        },
    },
    getters: {
        getByUUID: (state) => state.getByUUID,
    },
    actions: {
        async getByUUID({ commit }, payload) {
            const res = await axios.get(
                `/api/v1/guest/order/fetchByUUID/${payload.uuid}`
            );
            commit("getByUUID", res.data.order);
            console.log(res.data.order);
            return res;
        },
        async uploadImagesByUUID({}, payload) {
            return await axios
                .post(`/api/v1/guest/order/uploadImagesByUUID`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async removeImageIdByUUID({}, payload) {
            return await axios
                .post(`/api/v1/guest/order/removeImageIdByUUID`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
