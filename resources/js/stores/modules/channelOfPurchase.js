export default {
    namespaced: true,
    state: {
        UseOnly: []
    },
    mutations: {
        UseOnly(state, data) {
            state.UseOnly = data;
        }
    },
    getters: {
        UseOnly: state => state.UseOnly
    },
    actions: {
        async UseOnly({ commit }) {
            try {
                const response = await axios.get(
                    "api/channelOfPurchase/useonly"
                );
                commit("UseOnly", response.data);
                return response;
            }catch (response){

            }
        }
    }
};
