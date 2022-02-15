export default {
    namespaced: true,
    state: {
        fetch: [],
        getRelationship: []
    },
    mutations: {
        fetch(state, data) {
            state.fetch = data;
        },
        getRelationship(state, data) {
            state.getRelationship = data;
        }
    },
    getters: {
        fetch: state => state.fetch,
        getRelationship: state => state.getRelationship
    },
    actions: {
        async fetch({ commit }) {
            await axios
                .get(`/api/admin/v1/order/category/sub/fetch`)
                .then(response => commit("fetch", response.data))
                .catch(error => log.error(error));
        },
        async getRelationship({}, payload) {
            await axios
                .get(
                    `/api/admin/v1/order/category/sub/${payload.id}/getRelationship`
                )
                .then(response => commit("getRelationship", response.data))
                .catch(error => log.error(error));
        }
    }
};
