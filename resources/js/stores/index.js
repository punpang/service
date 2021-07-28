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
import tableOrder from "@/js/stores/modules/shabuNooNee/tableOrder";
import loginByQrCode from "@/js/stores/modules/shabuNooNee/loginByQrCode";
import userType from "@/js/stores/modules/shabuNooNee/userType";
import kitchenQueueOrder from "@/js/stores/modules/shabuNooNee/kitchenQueueOrder";
import WaitressQueueOrder from "@/js/stores/modules/shabuNooNee/WaitressQueueOrder";
import cookingType from "@/js/stores/modules/shabuNooNee/cookingType";
import cookingDetail from "@/js/stores/modules/shabuNooNee/cookingDetail";

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
        priceRange,
        tableOrder,
        loginByQrCode,
        userType,
        kitchenQueueOrder,
        WaitressQueueOrder,
        cookingType,
        cookingDetail
    }
});
