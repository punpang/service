export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async getUploadImageByToken({}, token) {
            const res = await axios.get(
                "/api/v1/guest/order/" + token + "/uploadImageByToken"
            );
            return res;
        }
    }
};
