export default {
    namespaced: true,
    state: {
        self: {},
        sumQuantity: 0
    },
    mutations: {
        self(state, data) {
            state.self = data;
        },
        sumQuantity(state, data) {
            state.sumQuantity = data;
        }
    },
    getters: {
        self: state => state.self,
        sumQuantity: state => state.sumQuantity
    },
    actions: {
        async self({ commit }) {
            commit("self", {});
            await axios
                .get("/api/waitress/self")
                .then(res => {
                    commit("self", res.data.data);
                    commit("sumQuantity", res.data.sumQuantity);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async finished({}, payload) {
            const res = await axios.post(
                "/api/waitress/" + payload + "/finished"
            );
            return res;
        }
    }
};
