<template>
    <div>
        <v-app-bar app color="orange darken-3" dark>
            <v-app-bar-nav-icon
                @click="drawer"
                v-show="this.$store.getters['main/isLoggedIn'] == true"
            ></v-app-bar-nav-icon>

            <v-toolbar-title>PUNPANG</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn text v-if="this.$store.getters['main/isLoggedIn'] == true">{{
                this.$store.getters["main/User"].name
            }}</v-btn>
            <v-menu
                offset-y
                v-if="this.$store.getters['main/isLoggedIn'] == true"
            >
                <template v-slot:activator="{ on }">
                    <v-icon v-on="on">person</v-icon>
                </template>

                <v-list>
                    <v-list-item
                        v-for="menu in MenuProfiles"
                        :key="menu.icon"
                        :to="menu.to"
                    >
                        <v-list-item-title>
                            <v-icon left>{{ menu.icon }}</v-icon>
                            {{ menu.title }}
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        
    </div>
</template>

<script>
export default {
    props: ["Profile"],
    data() {
        return {
            MenuProfiles: [
                { icon: "exit_to_app", title: "ออกจากระบบ", to: "/admin/logout" }
            ]
        };
    },
    methods: {
        drawer(){
            this.$emit('emitDialogNavbar',)
        }
    }
};
</script>
