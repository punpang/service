export default {
    namespaced: true,
    state: {
        data: [],
        dataUseOnly: []
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
        }
    },
    getters: {
        data: state => state.data,
        dataUseOnly: state =>
            state.dataUseOnly
    },
    actions: {
        async get({ commit }) {
            const response = await axios.get("/api/product/category/sub");
            commit("get", response.data);
            return response;
        },
        async add({ dispatch }, payload) {
            try {
                const response = await axios.post(
                    "/api/product/category/sub/store",
                    payload
                );
                dispatch("get");
                return response;
            } catch ({ response }) {
                console.log(response);
                return response;
            }
        },
        async update({ dispatch }, payload) {
            try {
                const response = await axios.post(
                    "/api/product/category/sub/" + payload.id + "/edit",
                    payload
                );
                dispatch("get");
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async getUseOnly({ commit }) {
            const response = await axios.get("/api/product/category/sub/useonly");
            commit("getUseOnly", response.data);
            return response;
        }
    }
};
