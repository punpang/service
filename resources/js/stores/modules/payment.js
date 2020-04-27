export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async create({dispatch}, payload) {
            const response = await axios.post(
                "/api/payment/create",
                payload
            );
            return response;
        }
    }
};
