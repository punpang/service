import Vue from "vue";
import VueRouter from "vue-router";

import Home from "@/js/views/Home";
import Form from "@/js/views/Form";

Vue.use(VueRouter);

import DashboardComponent from "@/js/components/DashboardComponent";
import LoginComponent from "@/js/components/LoginComponent";
import LogoutComponent from "@/js/components/LogoutComponent";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
        meta: { requiresAuth: true }
    },
    {
        path: "/customer",
        name: "Customer",
        component: () => import("@/js/pages/orders/customer"),
        meta: { requiresAuth: true }
    },
    {
        path: "/product",
        name: "Product",
        component: () => import("@/js/pages/orders/product"),
        meta: { requiresAuth: true }
    },
    {
        path: "/order",
        name: "Order",
        component: () => import("@/js/pages/orders/order"),
        meta: { requiresAuth: true }
    },
    {
        path: "/about",
        name: "About",
        component: () =>
            import(/* webpackChunkName: "about" */ "@/js/views/About"),
        meta: { requiresAuth: true }
    },
    {
        path: "/form",
        name: "Form",
        component: Form,
        meta: { requiresAuth: true }
    },
    {
        path: "/order/test",
        name: "OrderTest",
        component: () =>
            import(/* webpackChunkName: "about" */ "@/js/views/Orders"),
        meta: { requiresAuth: true }
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardComponent,
        meta: { requiresAuth: true }
    },
    {
        path: "/login",
        name: "login",
        component: LoginComponent
    },
    {
        path: "/logout",
        name: "logout",
        component: LogoutComponent
    },
    /* punpang */
    {
        path: "/punpang/order/:token",
        name: "orderToken",
        component: () => import("@/js/pages/punpang/orders/show"),
    },
    {
        path: "/punpang/order/:token/:amount/payment",
        name: "orderTokenPayment",
        component: () => import("@/js/pages/punpang/orders/payment"),
    },
    {   // ส่งลิงก์อัปโหลดรูป
        path: "/punpang/order/:token/uploadImage",
        name: "orderTokenUploadImage",
        component: () => import("@/js/pages/punpang/orders/uploadImage"),
    },
];

const router = new VueRouter({
    history: true,
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
