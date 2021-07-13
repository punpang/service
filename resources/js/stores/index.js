import Vue from "vue";
import Vuex from "vuex";

import main from "@/js/stores/modules/main";

import productImage from "@/js/stores/modules/productImage";
////
import pusher from "@/js/stores/modules/pusher";
import productGroup from "@/js/stores/modules/shabuNooNee/productGroup";
import menuBar from "@/js/stores/modules/shabuNooNee/menuBar";
import product from "@/js/stores/modules/shabuNooNee/products";
import googleImage from "@/js/stores/modules/shabuNooNee/googleImage";
import diningTable from "@/js/stores/modules/shabuNooNee/diningTable";
import priceRange from "@/js/stores/modules/shabuNooNee/priceRange";



Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        main,
        productImage,
        ////
        pusher,
        productGroup,
        product,
        menuBar,
        googleImage,
        diningTable,
        priceRange
    }
});
