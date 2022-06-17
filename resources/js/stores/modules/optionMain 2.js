export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async productCheck({ }, payload) {
            const res = await axios.get("/api/product/option/" + payload + "/productCheck");
            return res;
        },
        async check({ }, payload) {
            const res = await axios.get("/api/product/option/" + payload.product_id + "/" + payload.subs1 + "/check")
            return res;
        },
        async store({ }, payload) {
            const res = await axios.post("/api/product/option/store", payload);
            return res;
        }
    }
};

