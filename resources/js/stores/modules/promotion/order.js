export default {
    namespaced: true,
    state: { fetchByUUID: {} },
    mutations: {
        fetchByUUID(state, data) {
            state.fetchByUUID = data;
        }
    },
    getters: {
        fetchByUUID: state => state.fetchByUUID
    },
    actions: {
        async store({}, payload) {
            const res = await axios.post(`/api/v1/guest/order/store`, payload);
            return res;
        },
        async fetchByUUID({ commit }, payload) {
            const res = await axios.get(
                `/api/v1/guest/order/${payload}/fetchByUUID`
            );
            commit("fetchByUUID", res.data.data);
        }
    }
};
