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
        async update({dispatch,},payload){
            const res = await axios.post("/api/product/"+ payload.id +"/update",payload);  
            dispatch("all");
            return res;
        },
        async all({commit}){
            commit("all",[])
            const res = await axios.get("/api/product/all");            
            commit("all",res.data.data)
        }
    }
};
