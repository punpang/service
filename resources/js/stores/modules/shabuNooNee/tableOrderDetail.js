export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async updateByWaitress({}, payload) {
            return await axios.post(
                `/api/waitress/${payload.table_order_detail_id}/tableOrderDetail`,
                payload
            );
        }
    }
};
