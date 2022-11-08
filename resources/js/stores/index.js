import Vue from "vue";
import Vuex from "vuex";

import main from "@/js/stores/modules/main";

import productImage from "@/js/stores/modules/productImage";
////
import pusher from "@/js/stores/modules/pusher";
import productGroup from "@/js/stores/modules/shabuNooNee/productGroup";
import menuBar from "@/js/stores/modules/shabuNooNee/menuBar";
// import product from "@/js/stores/modules/shabuNooNee/products";
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
import tableOrderDetail from "@/js/stores/modules/shabuNooNee/tableOrderDetail";

////////////////////////////////////////////////////////////////////////////////////////////////////
import promotion from "@/js/stores/modules/promotion/promotion";
import product from "@/js/stores/modules/promotion/product";
import order from "@/js/stores/modules/promotion/order";
import payment from "@/js/stores/modules/promotion/payment";
import punpangProduct from "@/js/stores/modules/punpang/product";
//
import orderText from "@/js/stores/modules/order/text";
import orderIndex from "@/js/stores/modules/order/order";
import orderKsher from "@/js/stores/modules/order/ksher";
import orderGuestUuid from "@/js/stores/modules/order/guestUuid";
import orderCategory from "@/js/stores/modules/order/category";
import orderCategorySub from "@/js/stores/modules/order/categorySub";
import orderCustomer from "@/js/stores/modules/order/customer";
import orderDateTimeGet from "@/js/stores/modules/order/dateTimeGet";
import orderChannel from "@/js/stores/modules/order/orderChannel";
import orderProductCake from "@/js/stores/modules/order/productCake";
import orderNoticeOfPaymentFromCustomer from "@/js/stores/modules/order/noticeOfPaymentFromCustomer";
import orderDetailTemp from "@/js/stores/modules/order/orderDetailTemp";
import orderTemp from "@/js/stores/modules/order/orderTemp";
import orderProductAddOn from "@/js/stores/modules/order/productAddOn";
import orderGoodsAddOn from "@/js/stores/modules/order/goodsAddOn";
import orderM4 from "@/js/stores/modules/order/m4";
import orderProductPrototype from "@/js/stores/modules/order/orderProductPrototype";
import orderImageGoodsReviewToCustomer from "@/js/stores/modules/order/imageGoodsReviewToCustomer";
import orderDeliveryService from "@/js/stores/modules/order/deliveryService";
import orderAdjustExcessPayment from "@/js/stores/modules/order/adjustExcessPayment";
import facebook from "@/js/stores/modules/order/facebook";
import line from "@/js/stores/modules/order/line";
import moneyServices from "@/js/stores/modules/order/moneyServices";
/////////////////////////
/// LUCKY REWAYD START ///
import orderLuckyReward from "@/js/stores/modules/order/luckyReward";
/// LUCKY REWAYD END ///

import posGoods from '@/js/stores/modules/pos/goods';
import posCategoryGoods from '@/js/stores/modules/pos/categoryGoods';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        main,
        productImage,
        // ////
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
        cookingDetail,
        tableOrderDetail,
        promotion,
        product,
        order,
        payment,
        /////
        punpangProduct,
        ///
        orderCategory,
        orderCategorySub,
        orderCustomer,
        orderDateTimeGet,
        orderChannel,
        orderProductCake,
        orderGuestUuid,
        orderLuckyReward,
        orderText,
        orderIndex,
        orderKsher,
        orderNoticeOfPaymentFromCustomer,
        orderDetailTemp,
        orderTemp,
        orderProductAddOn,
        orderGoodsAddOn,
        orderM4,
        orderProductPrototype,
        orderImageGoodsReviewToCustomer,
        orderDeliveryService,
        orderAdjustExcessPayment,
        facebook,
        line,
        moneyServices,
        //
        posGoods,
        posCategoryGoods
    },
});
