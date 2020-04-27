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
        },
        async cancel({}, payload) {
            const response = await axios.delete(
                "/api/payment/"+payload+'/cancel'
            );
            return response;
        }
    }
};
