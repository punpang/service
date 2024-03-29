export default {
    namespaced: true,
    state: {
        temps: [],
    },
    mutations: {
        temps(state, data) {
            state.temps = data;
        },
        pushTemps(state, data) {
            state.temps.push(data);
        },
    },
    getters: {
        temps: (state) => state.temps,
    },
    actions: {
        async create({ commit }, payload) {
            return await axios
                .post(`/api/admin/v1/order/detail/temp/create`, payload)
                .then((response) => {
                    // dispatch("fetchProduct", payload.ops);
                    console.log(response.data.temp);
                    commit("pushTemps", response.data.temp);
                    return response.status;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async update({ dispatch }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/temp/${payload.order_detail_temp.id}/update`,
                    payload
                )
                .then((response) => {
                    dispatch("fetch", {
                        order_temp: {
                            id: payload.order_detail_temp.order_temp_id,
                        },
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async delete({ dispatch }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/temp/${payload.order_detail_temp.id}/delete`,
                    payload
                )
                .then((response) => {
                    dispatch("fetch", {
                        order_temp: {
                            id: payload.order_detail_temp.order_temp_id,
                        },
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async fetch({ commit }, payload) {
            return await axios
                .get(
                    `/api/admin/v1/order/detail/temp/${payload.order_temp.id}/fetch`
                )
                .then((response) => {
                    commit("temps", response.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
