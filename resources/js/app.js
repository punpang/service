import "./bootstrap";
import Vue from "vue";
import Vuetify from "vuetify";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import store from "@/js/stores";

Vue.use(Vuetify);

import Routers from "@/js/routes.js";

import App from "@/js/views/App";

Routers.beforeEach((to, from, next) => {
    // check if the route requires authentication and user is not logged in
    if (
        to.matched.some(route => route.meta.requiresAuth) &&
        !store.getters["main/isLoggedIn"]
    ) {
        // redirect to login page
        const loginpath = window.location.pathname;
        next({ name: "login", query: { from: loginpath } });
        return;
    }

    // if logged in redirect to dashboard
    if (to.path === "/login" && store.getters["main/isLoggedIn"]) {
        next({ name: "dashboard" });
        return;
    }

    next();
});

// ค่าเริ่มต้น headers auth
axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("token");
axios.defaults.headers.post["Content-Type"] = "multipart/form-data";
//

import VueCurrencyInput from "vue-currency-input";
const pluginOptions = {
    globalOptions: { currency: null }
};

Vue.use(VueCurrencyInput, pluginOptions);
const app = new Vue({
    el: "#app",
    store,
    router: Routers,
    vuetify: new Vuetify({
        icons: {
            iconfont: "md"
        },
        theme: {
            dark: true
        }
    }),
    render: h => h(App)
});

export default app;
