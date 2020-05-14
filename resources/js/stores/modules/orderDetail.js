export default {
    namespaced: true,
    state: {
        dataUseOnly: [],
        getByOrderId: [],
        sum: "",
        count: ""
    },
    mutations: {
        dataUseOnly(state, data) {
            state.dataUseOnly = data;
        },
        getByOrderId(state, data) {
            state.getByOrderId = data;
        },
        sum(state, data) {
            state.sum = data;
        },
        count(state, data) {
            state.count = data;
        }
    },
    getters: {
        dataUseOnly: state => state.dataUseOnly,
        getByOrderId: state => state.getByOrderId,
        sum: state => state.sum,
        count: state => state.count
    },
    actions: {
        async store({ dispatch }, payload) {
            const res = await axios.post("api/order/detail/store", payload);
            //dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async update({ dispatch }, payload) {
            const res = await axios.post(
                "api/order/detail/" + payload.id + "/update",
                payload
            );
            //dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async delete({ dispatch }, payload) {
            const res = await axios.post(
                "api/order/detail/" + payload.detail_id + "/delete"
            );
            //dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async redelete({ dispatch }, payload) {
            const res = await axios.post(
                "api/order/detail/" + payload.detail_id + "/redelete"
            );
            //dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async UseOnly({ commit }, payload) {
            const response = await axios.post(
                "api/order/detail/" + payload + "useonly"
            );
            commit("dataUseOnly", response.data);
        },
        async getByOrderID({ commit, dispatch }, payload) {
            const response = await axios.get(
                "api/order/detail/" + payload + "/getByOrderID"
            );
            commit("sum", response.data.sum);
            commit("count", response.data.count);
            commit("getByOrderId", response.data.data);
        },

        getByOrderIDReset({ commit }) {
            commit("getByOrderId", []);
        },

        async sentLinkForUploadImage({}, payload) {
            console.log(payload);

            const res = await axios.post(
                "/api/order/detail/" +
                    payload.detail_id +
                    "/sentLinkForUploadImage",
                payload.form
            );
            console.log(res);

            return res;
        },

        async downloadImage({}, payload) {
            await axios.get("/api/order/detail/" + payload + "/downloadImage");
        }
    }
};
