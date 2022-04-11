export default {
    namespaced: true,
    state: {
        temp: {
            id: "",
            temp: {
                dateTimeGet: {
                    dateGet: new Date(
                        Date.now() - new Date().getTimezoneOffset() * 60000
                    )
                        .toISOString()
                        .substr(0, 10),
                    timeGet: "",
                },
                channel: "",
            },
        },
    },
    mutations: {
        temp(state, data) {
            state.temp = data;
        },
        setDateGet(state, data) {
            state.temp.temp.dateTimeGet.dateGet = data;
        },
        setTimeGet(state, data) {
            state.temp.temp.dateTimeGet.timeGet = data;
        },
    },
    getters: {
        temp: (state) => state.temp,
    },
    actions: {
        async setTemp({}, payload) {
            await axios
                .post(`/api/admin/v1/order/temp/setTemp`, payload)
                .then(
                    (response) => {}
                    // console.log(response)
                )
                .catch((err) => {
                    // console.log(err);
                });
        },
        async fetch({ commit }, payload) {
            await axios
                .get(`/api/admin/v1/order/temp/${payload.customer.id}/fetch`)
                .then((response) => {
                    if (response.data) {
                        commit("temp", response.data);
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
