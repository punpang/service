export default {
    namespaced: true,
    state: {
        useKsherChannelPayment: {},
        ksherPay: {}
    },
    mutations: {
        useKsherChannelPayment(state, data) {
            state.useKsherChannelPayment = data
        },
        ksherPay(state, data) {
            state.ksherPay = data
        }
    },
    getters: {
        useKsherChannelPayment: state => state.useKsherChannelPayment,
        ksherPay: state => state.ksherPay
    },
    actions: {
        async getUseKsherChannelPayment({ commit }) {
            const res = await axios.get(`/api/v1/guest/ksher/getUseKsherChannelPayment`)
            commit("useKsherChannelPayment", res.data)
        },
        async createKsherPay({ commit }, payload) {
            const res = await axios.post(`/api/v1/guest/ksher/orderCreate`, payload);
            commit("ksherPay", res.data)
            return res.data
        },
        async orderQuery({ }, payload) {
            const res = await axios.get(`/api/admin/v1/ksher/${payload.mch_order_no}/orderQuery`)
            return res
        },
    }
};

