export default {
    namespaced: true,
    state: {
        profiles: [],
    },
    mutations: {
        profiles(state, data) {
            state.profiles = data;
        },
    },
    getters: {
        profiles: (state) => state.profiles,
    },
    actions: {
        async search({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/line/search?${payload.params}`)
                .then((response) => {
                    commit("profiles", response.data);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },

        async connectProfile({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/line/${payload.profile.id}/connect_profile`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },

        async disconnectProfile({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/line/${payload.line_id}/disconnect_profile`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },
    },
};
