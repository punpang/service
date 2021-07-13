export default {
    namespaced: true,
    state: {
        all:[]
    },
    mutations: {
        all(state,data){
            state.all = data
        }

    },
    getters: {
        all:state => state.all
    },
    actions: {
        async all({commit}){
            const res = await axios.get("/api/priceRange/all")
            commit("all",res.data.data)
        }
    }
};

