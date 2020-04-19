import './bootstrap';
import Vue from 'vue';
import Vuetify from 'vuetify';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import store from '@/js/stores';

Vue.use(Vuetify);

import Routers from '@/js/routes.js';

import App from '@/js/views/App';

Routers.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login' })
        return
    }

    // if logged in redirect to dashboard
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'dashboard' })
        return
    }

    next()
})

const app = new Vue({
    el: '#app',
    store,
    router:Routers,
    vuetify:new Vuetify({
        icons: {
            iconfont: 'md',
          },
    }),
    render: h => h(App),
});

export default app;