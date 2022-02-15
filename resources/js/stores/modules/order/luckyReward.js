export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async getOTP({ }, payload) {
            const res = await axios.post("/api/admin/v1/lucky/reward/getOTP", payload)
            return res;
        },
        async register({ }, payload) {
            const res = await axios.post("/api/admin/v1/lucky/reward/register", payload)
            return res;
        },
        async getByUUID({ }, payload) {
            const res = await axios.post("/api/v1/guest/lucky/reward/getByUUID", payload)

            return res;
        },
        async openReward({ }, payload) {
            const res = await axios.post("/api/v1/guest/lucky/reward/openReward", payload)
            return res;
        },
        async getRedeemCode({ }, payload) {
            const res = await axios.post("/api/v1/guest/lucky/reward/getRedeemCode", payload)
            return res;
        },

    }
};

