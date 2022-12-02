export default {
    namespaced: true,
    state: {
        data: [],
    },
    mutations: {
        data(state, data) {
            state.data = data;
        },
    },
    getters: {
        data: (state) => state.data,
    },
    actions: {
        async createByUuid({}, payload) {
            const result = await axios.post(
                `/api/v1/guest/noticeOfPaymentFromCustomer/createByUuid`,
                payload
            );
            return result;
        },
        async getAllByAdmin({ commit }) {
            const result = await axios.get(
                `/api/admin/v1/noticeOfPaymentFromCustomer/getAllByAdmin`
            );
            commit("data", result.data);
        },
        async getCheckSlip({}, payload) {
            const result = await axios.get(
                `/api/admin/v1/noticeOfPaymentFromCustomer/${payload.ntpfc.id}/getCheckSlip`
            );
            return result;
        },
        async postCheckSlip({}, payload) {
            const result = await axios.post(
                `/api/admin/v1/noticeOfPaymentFromCustomer/postCheckSlip`,
                payload
            );
            return result;
        },
        async postUpdateSlip({}, payload) {
            const result = await axios.post(
                `/api/admin/v1/noticeOfPaymentFromCustomer/postUpdateSlip`,
                payload
            );
            return result;
        },
        async postAppealSlip({}, payload) {
            const result = await axios.post(
                `/api/admin/v1/noticeOfPaymentFromCustomer/postAppealSlip`,
                payload
            );
            return result;
        },

        async setCancel({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/noticeOfPaymentFromCustomer/${payload.id}/setCancel`
                )
                .then((response) => {
                    return response.data;
                })
                .catch((error) => {
                    log.error(error);
                });
        },
    },
};
