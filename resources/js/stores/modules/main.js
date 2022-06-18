export default {
    namespaced: true,
    state: {
        User: {},
        isLoggedIn: !!localStorage.getItem("token"),
        sizeOverlay: "64",
    },
    mutations: {
        User(state, data) {
            state.User = data;
        },
        loginUser(state) {
            state.isLoggedIn = true;
        },
        logoutUser(state) {
            state.isLoggedIn = false;
            state.User = {};
            state.profile = {
                name: "",
            };
        },
    },
    getters: {
        User: (state) => state.User,
        isLoggedIn: (state) => state.isLoggedIn,
        sizeOverlay: (state) => state.sizeOverlay,
    },
    actions: {},
};
