export default {
    namespaced: true,
    state: {
        profile: [],
    },
    mutations: {
        setProfile(state, data) {
            state.profile = data;
        },
    },
    getters: {
        profile: (state) => state.profile,
    },
    actions: {
        async get_profile({ commit }, payload) {
            return await axios
                .get(`/api/v1/guest/profile/psid?${payload.query}`)
                .then((response) => {
                    commit("setProfile", response.data);
                    return response;
                })
                .catch((err) => {
                    return err;
                });
        },
    },
};
