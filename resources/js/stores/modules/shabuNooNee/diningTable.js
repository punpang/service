export default {
    namespaced: true,
    state: {
        allTable: [],
        table: {}
    },
    mutations: {
        allTable(state, data) {
            state.allTable = data;
        },
        table(state, data) {
            state.table = data;
        }
    },
    getters: {
        allTable: state => state.allTable,
        table: state => state.table
    },
    actions: {
        async allTable({ commit }) {
            commit("allTable", []);
            const res = await axios.get("/api/diningTable/allTable");
            commit("allTable", res.data);
        },
        async store({ dispatch }, payload) {
            const res = await axios.post("/api/diningTable/store", payload);
            dispatch("allTable");
            return res;
        },
        async table({ commit }, payload) {
            commit("table", {});
            const res = await axios.get(
                "/api/diningTable/" + payload + "/table"
            );
            commit("table", res.data);
        },
        async tableUpdate({ commit }, payload) {
            commit("table", {});
            const res = await axios.post(
                "/api/diningTable/" + payload.id + "/tableUpdate",
                payload
            );
            commit("table", res.data.data);
            return res;
        },
        async tableChangePriceRange({ dispatch }, payload) {
            const res = await axios.post(
                "/api/diningTable/" + payload.id + "/tableChangePriceRange",
                payload
            );
            dispatch("table", payload.id);
            return res;
        }
    }
};
