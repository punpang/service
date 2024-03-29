export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async sendOTP({ }, payload) {
            const res = await axios.post("/api/v1/otp/store", payload);
            return res;
        },
        async verify({ }, payload) {
            const res = await axios.post("/api/v1/otp/verify", payload);
            return res;
        }
    }
};

