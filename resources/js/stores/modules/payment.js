export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async create({}, payload) {
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
        },
        async alert({}, payload) {
            const response = await axios.post(
                "/api/payment/alert",
                payload
            );
            return response;
        },
    }
};
