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
        component: LoginComponent
    },
    {
        path: "/admin/logout",
        name: "logout",
        component: LogoutComponent
    },
    { path: "*", name: "PageNotFound", component: PageNotFound },
    {
        path: "/promotions",
        name: "promotions",
        component: () => import("@/js/pages/promotions/index")
    },
    {
        path: "/promotion/:promotion_id",
        name: "promotionsId",
        component: () => import("@/js/pages/promotions/promotionId")
    },
    {
        path: "/order/:uuid",
        name: "orderUUID",
        component: () => import("@/js/pages/promotions/orderUUID")
    },
    {
        path: "/manages/payment/check",
        name: "managesPaymentCheck",
        component: () => import("@/js/pages/promotions/manages/checkPayment"),
        meta: { requiresAuth: true }
    },
    {
        path: "/manages/promotion/:id",
        name: "managesPromotionID",
        component: () => import("@/js/pages/promotions/manages/promotionId"),
        meta: { requiresAuth: true }
    },
    // {
    //     path: "/manages/order/run",
    //     name: "managesOrderID",
    //     component: () => import("@/js/pages/promotions/manages/orderRun"),
    //     meta: { requiresAuth: true }
    // },
    ////
    {
        path: "/menu",
        name: "menuCake",
        component: () => import("@/js/pages/punpang/menu"),
    }
];

const router = new VueRouter({
    history: true,
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
