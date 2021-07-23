export default {
    namespaced: true,
    state: {
        all: [],
        broths: []
    },
    mutations: {
        all(state, data) {
            state.all = data;
        },
        add(state, data) {
            state.all.unshift(data);
        },
        broths(state, data) {
            state.broths = data;
        }
    },
    getters: {
        all: state => state.all,
        broths: state => state.broths
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
        },

        async broths({ commit }) {
            commit("broths", []);
            await axios
                .get("/api/cashier/productGroup/broths")
                .then(response => {
                    commit("broths", response.data);
                });
        }
    }
};
