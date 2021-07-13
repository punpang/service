export default {
    namespaced: true,
    state: {
        allTable:[],
    },
    mutations: {
        allTable(state,data){
            state.allTable = data
        }
    },
    getters: {
        allTable:state => state.allTable
    },
    actions: {
        async allTable({commit}){
            commit("allTable",[]);
            const res = await axios.get("/api/diningTable/allTable")
            commit("allTable",res.data)
        },
        async store({dispatch},payload){
            const res = await axios.post("/api/diningTable/store",payload)
            dispatch("allTable");
            return res;
        }
    }
};

