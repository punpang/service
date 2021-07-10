export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            try {
                const response = await axios.post(
                    "/api/google/uploadImage",
                    payload
                );
                return response;
            } catch ({ response }) {
                return response;
            }
        },
    }
};

