export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async checkUUID({}, payload) {
            const res = await axios.post("/api/tableOrder/checkUUID", payload);
            return res;
        }
    }
};
