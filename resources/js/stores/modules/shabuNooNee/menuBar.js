export default {
    namespaced: true,
    state: {
        lists: [],
        all: [],
        selectMain: {}
    },
    mutations: {
        lists(state, data) {
            state.lists = data;
        },
        all(state, data) {
            state.all = data;
        },
        storeMain(state, data) {
            state.all.push(data);
        },
        selectMain(state, data) {
            state.selectMain = data;
        }
    },
    getters: {
        lists: state => state.lists,
        all: state => state.all,
        selectMain: state => state.selectMain
    },
    actions: {
        async lists({ commit }) {
            const res = await axios.get("/api/menuBar/lists");
            commit("lists", res.data);
        },
        async all({ commit }) {
            const res = await axios.get("/api/menuBar/all");
            commit("all", res.data);
        },
        async storeMain({ commit }, payload) {
            const res = await axios.post("/api/menuBar/storeMain", payload);
            commit("storeMain", res.data.data);
            return res;
        },
        async changeSub({}, payload) {
            const res = await axios.post(
                "/api/menuBar/" + payload.id + "/changeSub",
                payload
            );
            return res;
        },
        async changeMain({}, payload) {
            const res = await axios.post(
                "/api/menuBar/" + payload.id + "/changeMain",
                payload
            );
            return res;
        },
        async selectMain({ commit }) {
            const res = await axios.get("/api/menuBar/selectMain");
            commit("selectMain", res.data.data);
        }
    }
};
