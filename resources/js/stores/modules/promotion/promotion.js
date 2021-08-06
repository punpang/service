export default {
    namespaced: true,
    state: {
        fetchAll: [],
        fetchAllByID: []
    },
    mutations: {
        fetchAll(state, data) {
            state.fetchAll = data;
        },
        fetchAllByID(state, data) {
            state.fetchAllByID = data;
        }
    },
    getters: {
        fetchAll: state => state.fetchAll,
        fetchAllByID: state => state.fetchAllByID
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
        }
    }
};
