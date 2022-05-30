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
        path: "/manages/order/newOrder",
        name: "managesOrderNew",
        component: () => import("@/js/pages/order/newOrder"),
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
        path: "/manages/ksher/dayOff",
        name: "managesKsherDayOff",
        component: () => import("@/js/pages/ksher/dayOff.vue"),
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
        path: "/guest/order/auth/:uuid",
        name: "guestOrderAuthUuid",
        component: () => import("@/js/pages/guest/orders/uuid"),
    },
    {
        path: "/o/:uuid",
        name: "guestOrderAuthUuid",
        component: () => import("@/js/pages/guest/orders/uuid"),
    },
    {
        path: "/ksher/successfully",
        name: "guestOrderKsherSuccessfully",
        component: () => import("@/js/pages/guest/orders/ksher/successfully"),
    },
];

const router = new VueRouter({
    history: true,
    mode: "history",
    base: process.env.BASE_URL,
    routes,
});

export default router;
