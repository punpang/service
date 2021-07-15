export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async self({commit}){
            const res = await axios.get("/api/tableOrder/self")
        }
    }
};

