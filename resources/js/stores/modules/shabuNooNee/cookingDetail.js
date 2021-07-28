export default {
    namespaced: true,
    state: {
        self: []
    },
    mutations: {
        self(state, data) {
            state.self = data;
        }
    },
    getters: {
        self: state => state.self
    },
    actions: {
        async store({}, payload) {
            return await axios.post("/api/cashier/cookingDetail", payload);
        },
        async self({ commit }, payload) {
            await axios
                .get(`/api/cashier/${payload}/cookingDetail`)
                .then(response => {
                    commit("self", response.data.data);
                })
                .catch(error => {
                    console.log("[cookingDetail/self]", error);
                });
        },
        async cancelCookingDetail({}, payload) {
            return await axios.delete(`/api/cashier/cookingDetail/${payload}`);
        }
    }
};
