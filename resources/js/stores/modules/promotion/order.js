export default {
    namespaced: true,
    state: {
        fetchByUUID: {},
        fetchByID: {}
    },
    mutations: {
        fetchByUUID(state, data) {
            state.fetchByUUID = data;
        },
        fetchByID(state, data) {
            state.fetchByID = data;
        }
    },
    getters: {
        fetchByUUID: state => state.fetchByUUID,
        fetchByID: state => state.fetchByID
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
            commit("fetchByUUID", res.data);
        },
        async fetchByID({ commit }, payload) {
            const res = await axios.get(
                `/api/admin/order/${payload}/fetchByID`
            );
            commit("fetchByID", res.data);
        },
        async updateStatusGoodsDone({}, payload) {
            const res = await axios.post(
                `/api/admin/order/${payload}/updateStatusGoodsDone`
            );
            return res;
        },
        async updateStatusGoodsGet({}, payload) {
            const res = await axios.post(
                `/api/admin/order/${payload}/updateStatusGoodsGet`
            );

            return res;
        }
    }
};
