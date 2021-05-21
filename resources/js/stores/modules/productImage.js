export default {
    namespaced: true,
    state: {
        data: {},
        dataUseOnly: []
    },
    mutations: {
        add(state, data) {
            state.data = data;
        },
        get(state, data) {
            state.data = data;
        }
    },
    getters: {
        data: state => state.data
    },
    actions: {
        async get({ commit }) {
            const response = await axios.get("/api/product/image/");
            commit("get", response.data);
            return response;
        },
        async getUseOnly({ commit }) {
            const response = await axios.get("/api/product/image/useonly");
            commit("getUseOnly", response.data);
            return response;
        },
        async store({ commit }, payload) {
            try {
                const response = await axios.post(
                    "/api/product/image/store",
                    payload
                );
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async update({ dispatch }, payload) {
            try {
                console.log(payload);
                const response = await axios.post(
                    "/api/product/image/" + payload.id + "/update",
                    payload.formData
                );
                dispatch("product/get");
                return response;
            } catch ({ response }) {
                return response;
            }
        },

        async destroy({ commit }, payload) {
            try {
                const response = await axios.post(
                    "/api/product/image/" + payload + "/destroy"
                );
                return response;
            } catch ({ response }) {
                return response;
            }
        }
    }
};
