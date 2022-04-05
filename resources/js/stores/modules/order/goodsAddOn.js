export default {
    namespaced: true,
    state: {
        fetch: [],
    },
    mutations: {
        fetch(state, data) {
            state.fetch = data;
        },
        pushFetch(state, data) {
            state.fetch.push(data);
        },
    },
    getters: {
        fetch: (state) => state.fetch,
    },
    actions: {
        async fetch({ commit }, payload) {
            const params = `?id=${payload.id}&name=${payload.name}`;
            return await axios
                .get(`/api/admin/v1/order/goodsAddOn/fetch${params}`)
                .then((response) => {
                    // console.log(response.data);
                    commit("fetch", response.data);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        async updateOrCreate({ commit }, payload) {
            return await axios
                .post(`/api/admin/v1/order/goodsAddOn/updateOrCreate`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => console.error(err));
        },
    },
};
