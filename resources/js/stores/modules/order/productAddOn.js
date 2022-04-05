export default {
    namespaced: true,
    state: {
        fetch: {},
    },
    mutations: {
        fetch(state, data) {
            state.fetch = data;
        },
    },
    getters: {
        fetch: (state) => state.fetch,
    },
    actions: {
        async fetch({ commit }, payload) {
            const params = `?goods_add_on_id=${payload.goods_add_on_id}&am4_id=${payload.am4_id}&isFirst=${payload.isFirst}`;
            return await axios
                .get(`/api/admin/v1/order/productAddOn/fetch${params}`)
                .then((response) => {
                    // console.log(response.data);
                    commit("fetch", response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        async updateOrCreate({}, payload) {
            return await axios
                .post(`/api/admin/v1/order/productAddOn/create`, payload)
                .then((response) => {
                    // console.log(response);
                    // commit("fetch", response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
