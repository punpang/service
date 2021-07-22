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
                .get("/api/kitchen/self")
                .then(res => {
                    commit("self", res.data.data);
                    commit("sumQuantity", res.data.sumQuantity);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async nextToWaitress({}, payload) {
            const res = await axios.post(
                "/api/kitchen/" + payload + "/nextToWaitress"
            );
            return res;
        }
    }
};
