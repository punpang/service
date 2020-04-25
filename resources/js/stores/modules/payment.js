export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async create({}, payload) {
            console.log(payload);
            const response = await axios.post(
                "/api/payment/create",
                payload
            );
            console.log("store.payment / create", response);
            return response;
        }
    }
};
