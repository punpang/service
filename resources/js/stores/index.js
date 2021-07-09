import Vue from "vue";
import Vuex from "vuex";

import main from "@/js/stores/modules/main";
////
import pusher from "@/js/stores/modules/pusher";
import productGroup from "@/js/stores/modules/shabuNooNee/productGroup";
import menuBar from "@/js/stores/modules/shabuNooNee/menuBar";


Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        main,
        ////
        pusher,
        productGroup,
        menuBar
    }
});
