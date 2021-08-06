export default {
    namespaced: true,
    state: {
        fetchAll: [],
        fetchAllByID: [],
        countProduct: []
    },
    mutations: {
        fetchAll(state, data) {
            state.fetchAll = data;
        },
        fetchAllByID(state, data) {
            state.fetchAllByID = data;
        },
        countProduct(state, data) {
            state.countProduct = data;
        }
    },
    getters: {
        fetchAll: state => state.fetchAll,
        fetchAllByID: state => state.fetchAllByID,
        countProduct: state => state.countProduct
    },
    actions: {
        async fetchAll({ commit }) {
            const res = await axios.get(
                `/api/v1/guest/promotions/fetchAll/promotion`
            );
            commit("fetchAll", res.data);
        },
        async fetchAllByID({ commit }, payload) {
            commit("fetchAllByID", {});
            const res = await axios.get(
                `/api/admin/promotions/${payload.id}/fetchAllByID`
            );
            commit("fetchAllByID", res.data);
        },
        async countProduct({ commit }, payload) {
            commit("countProduct", {});
            const res = await axios.get(
                `/api/admin/promotions/${payload.promotion_id}/${payload.order_status_id}/countProduct`
            );
            commit("countProduct", res.data);
        }
    }
};
