import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

import main from "@/js/stores/modules/main";
import customer from "@/js/stores/modules/customer";
import product from "@/js/stores/modules/product";
import productImage from "@/js/stores/modules/productImage";
import productTag from "@/js/stores/modules/productTag";
import productCategory from "@/js/stores/modules/productCategory";
import productCategorySub from "@/js/stores/modules/productCategorySub";
import channelOfPurchase from "@/js/stores/modules/channelOfPurchase";
import order from "@/js/stores/modules/order";
import orderDetail from "@/js/stores/modules/orderDetail";
import snackbar from "@/js/stores/modules/snackbar";
import payment from "@/js/stores/modules/payment";
import orderPaymentMethod from "@/js/stores/modules/orderPaymentMethod";
import slip from "@/js/stores/modules/slip";
import punpang from "@/js/stores/modules/punpang";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        main,
        customer,
        product,
        productImage,
        productTag,
        productCategory,
        productCategorySub,
        channelOfPurchase,
        order,
        orderDetail,
        snackbar,
        payment,
        orderPaymentMethod,
        slip,
        //
        punpang,
    }
});
