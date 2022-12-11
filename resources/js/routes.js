import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import LoginComponent from "@/js/components/LoginComponent";
import LogoutComponent from "@/js/components/LogoutComponent";
import PageNotFound from "@/js/components/PageNotFound";

const routes = [
    {
        path: "/login",
        name: "login",
        component: LoginComponent,
    },
    {
        path: "/admin/logout",
        name: "logout",
        component: LogoutComponent,
    },
    { path: "*", name: "PageNotFound", component: PageNotFound },
    {
        path: "/promotions",
        name: "promotions",
        component: () => import("@/js/pages/promotions/index"),
    },
    {
        path: "/promotion/:promotion_id",
        name: "promotionsId",
        component: () => import("@/js/pages/promotions/promotionId"),
    },
    {
        path: "/order/:uuid",
        name: "orderUUID",
        component: () => import("@/js/pages/promotions/orderUUID"),
    },
    {
        path: "/manages/payment/check",
        name: "managesPaymentCheck",
        component: () => import("@/js/pages/promotions/manages/checkPayment"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/promotion/:id",
        name: "managesPromotionID",
        component: () => import("@/js/pages/promotions/manages/promotionId"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/sms/",
        name: "managesOrderNew",
        component: () => import("@/js/pages/sms/index"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/order/newOrder",
        name: "managesOrderNew",
        component: () => import("@/js/pages/order/newOrder"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/orders",
        name: "managesOrders",
        component: () => import("@/js/pages/order/index"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/orders/search",
        name: "managesOrders",
        component: () => import("@/js/pages/order/search"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/order/details",
        name: "managesOrderDetails",
        component: () => import("@/js/pages/order/details"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/order/pre-order-lists",
        name: "managesOrderDetails",
        component: () => import("@/js/pages/order/pre-order-list"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/ordersss",
        name: "managesOrder",
        component: () => import("@/js/pages/order/newOrder"),
        meta: { requiresAuth: true },
    },

    {
        path: "/test/drag-sort",
        name: "/test/drag-sort",
        component: () => import("@/js/pages/test/drag-sort"),
        meta: { requiresAuth: true },
    },
    {
        path: "/test/waitingForNameFile",
        name: "/test/waitingForNameFile",
        component: () =>
            import(
                "@/js/components/order/manages/goods/cake/productPrototype/waitingForNameFile"
            ),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/order/:id/alertPayment",
        name: "managesOrderIDAlertPayment",
        component: () => import("@/js/pages/order/alertPaymentByOrderID"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/order/:id/showOrderByID",
        name: "managesOrderShowOrderByID",
        component: () => import("@/js/pages/order/showOrderByID"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/order/:id/paymentOrderByID",
        name: "managesOrderIDpromptPaymentOrderByID",
        component: () => import("@/js/pages/order/paymentOrderByID"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/order/checkNoticeOfPaymentFromCustomer",
        name: "managesOrderCheckNoticeOfPaymentFromCustomer",
        component: () =>
            import("@/js/pages/order/checkNoticeOfPaymentFromCustomer"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/ksher/channel",
        name: "managesKsherChannel",
        component: () => import("@/js/pages/ksher/channel"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/ksher/settlement",
        name: "managesKsherSettlement",
        component: () => import("@/js/pages/ksher/settlement"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/ksher/dayOff",
        name: "managesKsherDayOff",
        component: () => import("@/js/pages/ksher/dayOff.vue"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/settings/store/dayOff",
        name: "managesStoreDayOff",
        component: () => import("@/js/pages/store/dayOff.vue"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/facebook/webhook",
        name: "managesOrderShowOrderByID",
        component: () => import("@/js/pages/order/showOrderByID"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/settings/facebook/reply",
        name: "managesOrderShowOrderByID",
        component: () => import("@/js/pages/facebook/reply"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/settings/general",
        name: "managesSetting",
        component: () => import("@/js/pages/setting"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/settings/products/options",
        name: "/manages/settings/products/options",
        component: () => import("@/js/pages/order/products/options"),
        meta: { requiresAuth: true },
    },

    {
        path: "/manages/settings/products/pos",
        name: "/manages/settings/products/pos",
        component: () => import("@/js/pages/order/pos/goods"),
        meta: { requiresAuth: true },
    },

    // {
    //     path: "/manages/order/run",
    //     name: "managesOrderID",
    //     component: () => import("@/js/pages/promotions/manages/orderRun"),
    //     meta: { requiresAuth: true }
    // },
    ////
    {
        path: "/manages/menuBar",
        name: "managesLuckyRegister",
        component: () => import("@/js/pages/admin/menuBar"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/lucky/register",
        name: "managesLuckyRegister",
        component: () => import("@/js/pages/lucky/register"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/lucky/redeem-code",
        name: "managesLuckyRedeemCode",
        component: () => import("@/js/pages/lucky/redeem-code"),
        meta: { requiresAuth: true },
    },
    {
        path: "/manages/lucky/getLink",
        name: "managesLuckyGetLink",
        component: () => import("@/js/pages/lucky/getLink"),
        meta: { requiresAuth: true },
    },
    {
        path: "/lucky/reward/:uuid",
        name: "managesLuckyRedeemCode",
        component: () => import("@/js/pages/lucky/rewardUUID"),
    },

    // guest
    {
        path: "/menu",
        name: "menuCake",
        component: () => import("@/js/pages/punpang/menu"),
    },
    {
        path: "/menu/orders",
        name: "menuCakeOrder",
        component: () => import("@/js/pages/punpang/menuOrder"),
    },
    // {
    //     path: "/guest/order/auth/:uuid",
    //     name: "guestOrderAuthUuid",
    //     component: () => import("@/js/pages/guest/orders/uuid"),
    // },
    {
        path: "/o/:uuid",
        name: "guestOrderUUID",
        component: () => import("@/js/pages/guest/orders/uuid"),
    },
    {
        path: "/upload_slip/:uuid",
        name: "guestUploadSlip",
        component: () => import("@/js/pages/guest/orders/upload_slip_uuid"),
    },
    {
        path: "/r/:shotlink",
        name: "guestShotlink",
        component: () => import("@/js/pages/guest/orders/shotlink"),
    },
    {
        path: "/learning/conditions/order",
        name: "learningConditionsOrder",
        component: () => import("@/js/pages/learning/conditions/order"),
    },
    {
        path: "/ksher/successfully",
        name: "guestOrderKsherSuccessfully",
        component: () => import("@/js/pages/guest/orders/ksher/successfully"),
    },

    {
        path: "/verify_identity/register_member/:token",
        name: "verify_identityRegister_member",
        component: () =>
            import("@/js/pages/guest/verify_identity/register_member"),
    },
];

const router = new VueRouter({
    history: true,
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;
