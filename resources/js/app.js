import "./bootstrap";
import Vue from "vue";
import Vuetify from "vuetify";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import store from "@/js/stores";
window.Vue = require("vue");

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
    if (to.path === "/admin/login" && store.getters["main/isLoggedIn"]) {
        next({ name: "home" });
        return;
    }

    next();
});

// ค่าเริ่มต้น headers auth
axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("token");
axios.defaults.headers.post["Content-Type"] = "multipart/form-data";
//

// crrency
import VueCurrencyInput from "vue-currency-input";
const pluginOptions = {
    globalOptions: { currency: null }
};
Vue.use(VueCurrencyInput, pluginOptions);

// clipboard
import VueClipboard from "vue-clipboard2";
Vue.use(VueClipboard);

// notification
import VueToast from "vue-toast-notification";
// Import one of available themes
//import "vue-toast-notification/dist/theme-default.css";
import "vue-toast-notification/dist/theme-sugar.css";
Vue.use(VueToast, {
    // One of options
    position: "bottom",
    duration: 5000
});

// overlay
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
// Init plugin
Vue.use(Loading);

//vue-sweetalert2
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
Vue.use(VueSweetalert2);

const app = new Vue({
    el: "#app",
    store,
    router: Routers,
    vuetify: new Vuetify({
        icons: {
            iconfont: "md"
        },
        theme: {
            dark: false
        }
    }),
    render: h => h(App)
});

export default app;
