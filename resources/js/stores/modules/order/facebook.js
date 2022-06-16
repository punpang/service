export default {
    namespaced: true,
    state: {
        fetch: [],
        fetchWebhook: [],
        profiles: [],
    },
    mutations: {
        fetch(state, data) {
            state.fetch = data;
        },
        fetchWebhook(state, data) {
            state.fetchWebhook = data;
        },
        profiles(state, data) {
            state.profiles = data;
        },
    },
    getters: {
        fetch: (state) => state.fetch,
        fetchWebhook: (state) => state.fetchWebhook,
        profiles: (state) => state.profiles,
    },
    actions: {
        async fetch({ commit }) {
            return await axios
                .get(`/api/admin/v1/facebook/reply/fetch`)
                .then((response) => {
                    commit("fetch", response.data.reply);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },
        async store({}, payload) {
            return await axios
                .post(`/api/admin/v1/facebook/reply/store`, payload)
                .then((response) => {
                    // commit("fetch", response.data.reply);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },
        async update({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/facebook/reply/${payload.reply.id}/update`,
                    payload
                )
                .then((response) => {
                    // commit("fetch", response.data.reply);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },
        async fetchWebhook({ commit }, payload) {
            let isNullReply = "";
            if (payload) {
                if (payload.isNullReply)
                    isNullReply = `isNullReply=${payload.isNullReply}`;
            }

            return await axios
                .get(`/api/admin/v1/facebook/webhook/fetch?${isNullReply}`)
                .then((response) => {
                    commit("fetchWebhook", response.data);
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },

        async addReplyToWebhook({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/facebook/webhook/${payload.webhook.id}/addReply`,
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
        async removeReplyOfWebhook({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/facebook/webhook/${payload.webhook.id}/removeReply`
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                    return err;
                });
        },

        async searchProfile({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/facebook/search_profile?${payload.params}`)
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
                    `/api/admin/v1/facebook/${payload.profile.id}/connect_profile`,
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
                    `/api/admin/v1/facebook/${payload.facebook_id}/disconnect_profile`,
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

        async register_member({}, payload) {
            return await axios
                .post(
                    `/api/v1/guest/verify_identity/${payload.token}/register_member`,
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
