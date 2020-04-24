export default {
    namespaced: true,
    state: {
        dataUseOnly: [],
        getByOrderId: [],
        cost: "",
        count: "",
    },
    mutations: {
        dataUseOnly(state, data) {
            state.dataUseOnly = data;
        },
        getByOrderId(state, data) {
            state.getByOrderId = data;
        },
        cost(state, data) {
            state.cost = data;
        },
        count(state, data) {
            state.count = data;
        },
    },
    getters: {
        dataUseOnly: state => state.dataUseOnly,
        getByOrderId: state => state.getByOrderId,
        cost: state => state.cost,
        count: state => state.count,
        
    },
    actions: {
        async store({ dispatch }, payload) {
            const res = await axios.post("api/order/detail/store", payload);
            dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async update({ dispatch }, payload) {
            const res = await axios.post(
                "api/order/detail/" + payload.id + "/update",
                payload
            );
            dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async delete({ dispatch }, payload) {
            const res = await axios.delete(
                "api/order/detail/" + payload.detail_id + "/delete"
            );
            dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async redelete({ dispatch }, payload) {
            const res = await axios.patch(
                "api/order/detail/" + payload.detail_id + "/redelete"
            );
            dispatch("getByOrderID", payload.order_id);
            return res;
        },
        async UseOnly({ commit }, payload) {
            const response = await axios.post(
                "api/order/detail/" + payload + "useonly"
            );
            commit("dataUseOnly", response.data);
        },
        async getByOrderID({ commit }, payload) {
            const response = await axios.get(
                "api/order/detail/" + payload + "/getByOrderID"
            );
            commit("cost", response.data.cost);
            commit("count", response.data.count);
            commit("getByOrderId", response.data.data);
        },
        getByOrderIDReset({ commit }) {
            commit("getByOrderId", []);
        }
    }
};
