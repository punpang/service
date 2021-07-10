export default {
    namespaced: true,
    state: {
        all:[]
    },
    mutations: {
        all(state,data){
            state.all = data
        },
        allUnshift(state,data){
            state.all.unshift(data)
        }
    },
    getters: {
        all:state => state.all
    },
    actions: {
        async store({commit},payload){
            const res = await axios.post("/api/product/store",payload);
            commit("allUnshift",res.data.data);
            return res;
        },
        async all({commit}){
            const res = await axios.get("/api/product/all");
            commit("all",res.data.data)
        }
    }
};
