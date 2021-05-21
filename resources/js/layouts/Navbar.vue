<template>
    <v-navigation-drawer
            app
            v-if="this.$store.getters['main/isLoggedIn'] == true"
            v-model="drawer"
        >
            <v-list>
                <v-list-item
                    link
                    v-for="menu in menus"
                    :key="menu.name"
                    :to="menu.to"
                >
                    <v-list-item-icon>
                        <v-icon>{{ menu.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ menu.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
</template>

<script>
export default {
    props:[
        'drawer'
    ],
    data() {
        return {
            menus: [
                { icon: "home", title: "หน้าแรก", to: "/admin" },
            ],
        };
    },
    methods: {
    }
};
</script>
