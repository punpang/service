export default {
    namespaced: true,
    state: {
        fetch: [],
    },
    mutations: {
        fetch(state, data) {
            state.fetch = data;
        },
    },
    getters: {
        fetch:state => state.fetch,
        fetch2:state => state.fetch
    },
    actions: {
        async fetch({ commit }, payload) {
            const params = `?id=${payload.id}&name=${payload.name}`;
            return await axios
                .get(`/api/admin/v1/order/m4/fetch${params}`)
                .then((response) => {
                    // console.log(response.data);
                    commit("fetch",response.data)
                })
                .catch((error) => {
                    console.error(error);
                });
            F;
        },
    },
};
