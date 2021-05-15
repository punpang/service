export default {
    namespaced: true,
    state: {
        unVerifyReasoning:[]
    },
    mutations: {
        unVerifyReasoning(state,data){
            state.unVerifyReasoning = data
        }
    },
    getters: {
        unVerifyReasoning:state => state.unVerifyReasoning
    },
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
                
            const response = await axios.post("/api/payment/"+payload.slip_id+"/unVerifySlip",payload);

            return response;
        },
        async unVerifyReasoning({commit}){
            const response = await axios.get("/api/payment/unVerifyReasoning");
            commit('unVerifyReasoning',response.data)
            return response;
        },
        async notPayDeposit({},payload){
            const response = await axios.post("/api/payment/notPayDeposit",payload);
            return response;
        },
        async scb({},payload){
            const response = await axios.post("/api/payment/scb",payload);
            console.log(response);
            return response;
        }

        
    }
};
