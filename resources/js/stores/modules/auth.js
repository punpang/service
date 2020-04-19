export default {
    namespaced: true,
    state: {
        isLoggedIn: !!localStorage.getItem("token")
    },
    mutations: {
        AuthToken(state) {
            state.AuthToken = "Bearer " + localStorage.getItem("token");
        },
        User(state, data) {
            state.User = data;
        },
        loginUser(state) {
            state.isLoggedIn = true;
        },
        logoutUser(state) {
            state.isLoggedIn = false;
            state.profile = {
                name: ""
            };
        }
    },
    getters: {
        AuthToken: state => state.AuthToken
    },
    actions: {}
};
