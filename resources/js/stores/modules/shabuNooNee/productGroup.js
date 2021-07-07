export default {
    namespaced: true,
    state: {
        all: []
    },
    mutations: {
        all(state, data) {
            state.all = data;
        },
        add(state, data) {
            state.all.unshift(data);
        }
    },
    getters: {
        all: state => state.all
    },
    actions: {
        async store({ commit }, payload) {
            const res = await axios.post("/api/product/group", payload);
            commit("add", res.data.data);
            return res;
        },
        async all({ commit }) {
            const res = await axios.get("/api/product/group/all");
            commit("all", res.data.data);
            return res;
        },
        async switchStatus({}, payload) {
            const res = await axios.post(
                "/api/product/group/" + payload.id + "/switchStatus",
                payload
            );
            return res;
            //console.log("done switchStatus",res);
        },
        async update({ dispatch }, payload) {
            const res = await axios.post(
                "/api/product/group/" + payload.id + "/update",
                payload
            );
            dispatch("all");
            return res;
        }
    }
};
