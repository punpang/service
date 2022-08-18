export default {
    namespaced: true,
    state: {
        useKsherChannelPayment: {},
        ksherPay: [],
        fetch_day_offs: [],
    },
    mutations: {
        useKsherChannelPayment(state, data) {
            state.useKsherChannelPayment = data;
        },
        ksherPay(state, data) {
            state.ksherPay = data;
        },
        fetch_day_offs(state, data) {
            state.fetch_day_offs = data;
        },
    },
    getters: {
        useKsherChannelPayment: (state) => state.useKsherChannelPayment,
        ksherPay: (state) => state.ksherPay,
        kshers: (state) => state.kshers,
        fetch_day_offs: (state) => state.fetch_day_offs,
    },
    actions: {
        async getUseKsherChannelPayment({ commit }) {
            const res = await axios.get(
                `/api/v1/guest/ksher/getUseKsherChannelPayment`
            );
            commit("useKsherChannelPayment", res.data);
        },
        async createKsherPay({ commit }, payload) {
            commit("ksherPay", []);
            const res = await axios.post(
                `/api/v1/guest/ksher/orderCreate`,
                payload
            );
            commit("ksherPay", res.data);
            return res.data;
        },
        async orderQuery({}, payload) {
            const res = await axios.get(
                `/api/admin/v1/ksher/${payload.mch_order_no}/orderQuery`
            );
            return res;
        },
        async checkStatusPaid({}, payload) {
            return await axios
                .get(
                    `/api/v1/guest/ksher/${payload.mch_order_no}/checkStatusPaid`
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },

        async fetch({ commit }, payload) {
            const params = payload.params ? payload.params : "";
            return await axios
                .get(`/api/admin/v1/ksher/fetch?${params}`)
                .then((response) => {
                    commit("ksherPay", response.data);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },

        async setDayOff({}, payload) {
            return await axios
                .post(`/api/admin/v1/ksher/setDayOff`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },

        async fetch_ksher_day_off({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/ksher/dayOff/fetch?${payload}`)
                .then((response) => {
                    commit("fetch_day_offs", response.data);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },

        async remove_ksher_day_off({}, payload) {
            return await axios
                .post(`/api/admin/v1/ksher/dayOff/${payload.id}/remove`)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },

        async update_status_use({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/ksher/${payload.ksher.id}/update_status_use`
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },

        async update_sort({}, payload) {
            return await axios
                .post(`/api/admin/v1/ksher/update_sort`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },
    },
};
