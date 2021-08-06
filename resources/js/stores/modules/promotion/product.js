export default {
    namespaced: true,
    state: {
        fetchByPromotionID: []
    },
    mutations: {
        fetchByPromotionID(state, data) {
            state.fetchByPromotionID = data;
        }
    },
    getters: {
        fetchByPromotionID: state => state.fetchByPromotionID
    },
    actions: {
        async fetchByPromotionID({ commit }, payload) {
            const res = await axios.get(
                `/api/v1/guest/product/${payload}/fetchByPromotionID`
            );
            commit("fetchByPromotionID", res.data);
            return res;
        }
    }
};
