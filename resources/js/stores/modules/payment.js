export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async create({}, payload) {
            const response = await axios.post("/api/payment/create", payload);

            return response;
        },
        async cancel({}, payload) {
            try {
                const response = await axios.post(
                    "/api/payment/" + payload + "/cancel"
                );
                return response;
            } catch (response) {
                return response;
            }
        },
        async alert({}, payload) {
            const response = await axios.post("/api/payment/alert", payload);
            return response;
        },
        async checkRef({}, payload) {
            const response = await axios.post("/api/payment/checkRef", payload);
            return response;
        },
        async unVerifySlip({},payload){
            console.log(payload);
            
            const response = await axios.post("/api/payment/"+payload+"/unVerifySlip");

            return response;
        }
    }
};
