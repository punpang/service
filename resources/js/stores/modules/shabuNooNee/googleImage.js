export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            console.log(payload);
            try {
                const response = await axios.post(
                    "/api/v1/guest/google/uploadImage",
                    payload
                );
                return response;
            } catch ({ response }) {
                return response;
            }
        },
        async storeNotAuth({}, payload) {
            try {
                const response = await axios.post(
                    "/api/v1/guest/google/uploadImage",
                    payload
                );
                return response;
            } catch ({ response }) {
                return response;
            }
        },
    }
};

