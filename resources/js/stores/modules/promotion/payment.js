export default {
    namespaced: true,
    state: {
        fetchCheck: [],
        fetchByOrderId: {}
    },
    mutations: {
        fetchCheck(state, data) {
            state.fetchCheck = data;
        },
        fetchByOrderId(state, data) {
            state.fetchByOrderId = data;
        }
    },
    getters: {
        fetchCheck: state => state.fetchCheck,
        fetchByOrderId: state => state.fetchByOrderId
    },
    actions: {
        async store({}, payload) {
            const res = await axios.post(
                `/api/v1/guest/payment/store`,
                payload
            );
            return res;
        },
        async storeCash({}, payload) {
            const res = await axios.post(
                `/api/v1/guest/payment/cash/store`,
                payload
            );
            return res;
        },

        async fetchCheck({ commit }) {
            const res = await axios.get(`/api/admin/payment/fetchCheck`);

            commit("fetchCheck", res.data);
            return res;
        },
        async fetchByOrderId({ commit }, payload) {
            const res = await axios.get(
                `/api/admin/payment/${payload}/fetchByOrderId`
            );
            commit("fetchByOrderId", res.data);
        },
        async confirm({}, payload) {
            const res = await axios.post(
                `/api/admin/payment/${payload.payment_id}/confirm`,
                payload
            );

            return res;
        },
        async confirmOnline({}, payload) {
            const res = await axios.post(
                `/api/admin/payment/${payload.id}/confirmOnline`,
                payload
            );
            return res;
        },
        async cancel({}, payload) {
            const res = await axios.post(
                `/api/admin/payment/${payload.payment_id}/cancel`,
                payload
            );

            return res;
        }
    }
};
