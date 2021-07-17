import Vue from "vue";
import VueRouter from "vue-router";

import Home from "@/js/views/Home";
import Form from "@/js/views/Form";

Vue.use(VueRouter);

import DashboardComponent from "@/js/components/DashboardComponent";
import LoginComponent from "@/js/components/LoginComponent";
import LogoutComponent from "@/js/components/LogoutComponent";
import PageNotFound from "@/js/components/PageNotFound";

const routes = [
    {
        path: "/home",
        name: "home",
        component: Home
    },
    {
        path: "/todos/:id",
        name: "todos",
        component: () => import("@/js/components/todos/TodoApp")
    },
    {
        path: "/todos2",
        name: "todos2",
        component: () => import("@/js/components/todos/TodoApp2")
    },
    {
        path: "/admin/dashboard",
        name: "adminDashboard",
        component: () => import("@/js/pages/admin/dashboard"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/product",
        name: "adminProduct",
        component: () => import("@/js/pages/admin/product/product"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/product/group",
        name: "adminProductGroup",
        component: () => import("@/js/pages/admin/product/group"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/menuBar",
        name: "adminMenuBar",
        component: () => import("@/js/pages/admin/menuBar/"),
        meta: { requiresAuth: true }
    },

    {
        path: "/diningtable/manage",
        name: "diningTableManage",
        component: () => import("@/js/pages/diningTable/manage"),
        meta: { requiresAuth: true }
    },

    {
        path: "/table",
        name: "tableOrder",
        component: () => import("@/js/pages/tableOrder/table"),
        meta: { requiresAuth: true }
    },

    {
        path: "/table/close",
        name: "tableClose",
        component: () => import("@/js/pages/tableOrder/close"),
    },
    /////////////////////////////////////////
    {
        path: "/admin/index",
        name: "adminpage",
        component: Home,
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/customer",
        name: "Customer",
        component: () => import("@/js/pages/orders/customer"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/products",
        name: "Product",
        component: () => import("@/js/pages/orders/product"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/order",
        name: "Order",
        component: () => import("@/js/pages/orders/order"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/about",
        name: "About",
        component: () =>
            import(/* webpackChunkName: "about" */ "@/js/views/About"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/form",
        name: "Form",
        component: Form,
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/order/test",
        name: "OrderTest",
        component: () =>
            import(/* webpackChunkName: "about" */ "@/js/views/Orders"),
        meta: { requiresAuth: true }
    },
    {
        path: "/admin/dashboard",
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
        path: "/admin/logout",
        name: "logout",
        component: LogoutComponent
    }, //SYSTEM
    {
        path: "/testModule",
        name: "testModule",
        component: () => import("@/js/pages/testModule")
    },
    /* punpang */
    {
        path: "/punpang/order/:token",
        name: "orderToken",
        component: () => import("@/js/pages/punpang/orders/show")
    },
    {
        path: "/punpang/order/:token/:amount/payment",
        name: "orderTokenPayment",
        component: () => import("@/js/pages/punpang/orders/payment")
    },
    {
        // ส่งลิงก์อัปโหลดรูป
        path: "/punpang/order/:token/uploadImage",
        name: "orderTokenUploadImage",
        component: () => import("@/js/pages/punpang/orders/uploadImage")
    },
    /////////////////////////////
    { path: "*", name: "PageNotFound", component: PageNotFound }
];

const router = new VueRouter({
    history: true,
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
