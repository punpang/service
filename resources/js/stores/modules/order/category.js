export default {
    namespaced: true,
    state: {
        getSize: [],
        getCakeTexture: [],
        getFormat: []
    },
    mutations: {
        getSize(state, data) {
            state.getSize = data;
        },
        getCakeTexture(state, data) {
            state.getCakeTexture = data;
        },
        getFormat(state, data) {
            state.getFormat = data;
        }
    },
    getters: {
        getSize: state => state.getSize,
        getCakeTexture: state => state.getCakeTexture,
        getFormat: state => state.getFormat
    },
    actions: {
        async getSize({ commit }) {
            await axios
                .get(`/api/admin/v1/order/category/getSize`)
                .then(res => {
                    commit("getSize", res.data);
                });
        },
        async getCakeTexture({ commit }, payload) {
            await axios
                .get(
                    `/api/admin/v1/order/category/${payload.id}/getCakeTexture`
                )
                .then(res => {
                    commit("getCakeTexture", res.data);
                });
        },
        async getFormat({ commit }, payload) {
            await axios
                .get(
                    `/api/admin/v1/order/category/${payload.id}/getCategoryRelationship1`
                )
                .then(res => {
                    commit("getFormat", res.data);
                });
        }
    }
};
