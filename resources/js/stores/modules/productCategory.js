export default {
    namespaced: true,
    state: {
        data: [],
        dataUseOnly: [],
        dataUseOnlyWithSubs: []
    },
    mutations: {
        add(state, data) {
            state.data.push(data);
        },
        get(state, data) {
            state.data = data;
        },
        getUseOnly(state, data) {
            state.dataUseOnly = data;
        },
        getUseOnlyWithSubs(state, data) {
            state.dataUseOnlyWithSubs = data;
        }
    },
    getters: {
        data: state => state.data,
        dataUseOnly: state => state.dataUseOnly,
        dataUseOnlyWithSubs: state => state.dataUseOnlyWithSubs
    },
    actions: {
        async get({ commit }) {
            const response = await axios.get("/api/product/category");
            commit("get", response.data);
            return response;
        },
        async getUseOnly({ commit }) {
            const response = await axios.get("/api/product/category/useonly");
            commit("getUseOnly", response.data);
            return response;
        },
        async add({ commit }, payload) {
            try {
                const response = await axios.post(
                    "/api/product/category/store",
                    payload
                );
                commit("add", response.data);
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async update({ dispatch }, payload) {
            try {
                const response = await axios.post(
                    "/api/product/category/" + payload.id + "/edit",
                    payload
                );
                dispatch("get");
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async getUseOnlyWithSubs({ commit }) {
            const response = await axios.get(
                "/api/product/category/useonly/with/subs"
            );
            commit("getUseOnlyWithSubs", response.data);
            return response;
        },
        async getSubByID({ }, payload) {
            const response = await axios.get("/api/product/category/" + payload + "/subs");
            return response;
        }
    }
};
