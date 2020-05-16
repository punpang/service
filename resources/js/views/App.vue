<template>
    <v-app>
        <Toolbar
            :Profile="Profile"
            @emitDialogNavbar="emitDialogNavbar"
        ></Toolbar>

        <NavbarAdmin
            :drawer="drawer"
            v-if="this.$store.getters['main/User'].type == 1"
        ></NavbarAdmin>
        <Navbar :drawer="drawer" v-else></Navbar>

        <v-content>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-content>
        <v-footer app>
            <!-- -->
        </v-footer>
    </v-app>
</template>

<script>
import Toolbar from "@/js/layouts/Toolbar";
import Navbar from "@/js/layouts/Navbar";
import NavbarAdmin from "@/js/layouts/NavbarAdmin";

export default {
    name: "App",
    components: {
        Toolbar,
        Navbar,
        NavbarAdmin
    },
    data() {
        return {
            Profile: {},
            drawer: false
        };
    },
    methods: {
        emitDialogNavbar() {
            this.drawer = !this.drawer;
        }
    },
    async beforeCreate() {
        if (localStorage.token) {
            await axios
                .get("/api/user", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("token")
                    }
                })
                .then(response => {
                    //this.$store.commit("main/loginUser");
                    this.$store.commit("main/User", response.data);
                })
                .catch(error => {
                    if (
                        error.response.status == 400 ||
                        error.response.status === 401 ||
                        error.response.status === 403
                    ) {
                        this.$store.commit("main/logoutUser");
                        localStorage.setItem("token", "");
                        this.$router.replace({ name: "login" });
                    }
                });
        }
    }
};
</script>

<style>
.v-application {
    font-family: "Sarabun", sans-serif;
}
</style>
