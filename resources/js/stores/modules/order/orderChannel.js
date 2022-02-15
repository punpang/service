export default {
    namespaced: true,
    state: {
        fetchUse: [],
        msg: {
            text: {
                titleMain: "ช่องทางการสั่งซื้อ",
                selectChannel: "เลือกช่องทางการสั่งซื้อ"
            },
            icon: {
                titleMain: "settings",
                selectChannel: "list_alt"
            }
        },
        rules: {
            channel: [v => !!v || "ห้ามเว้นว่าง"]
        }
    },
    mutations: {
        fetchUse(state, data) {
            state.fetchUse = data;
        }
    },
    getters: {
        msg: state => state.msg,
        fetchUse: state => state.fetchUse,
        rules: state => state.rules
    },
    actions: {
        async fetchUse({ commit }) {
            return await axios
                .post(`/api/admin/v1/order/channel/fetchUse`)
                .then(response => {
                    commit("fetchUse", response.data);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    }
};
