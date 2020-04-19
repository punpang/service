<template>
    <v-app>
        <Toolbar :Profile="Profile"></Toolbar>

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

export default {
    name: "App",
    components: {
        Toolbar,
        Navbar
    },
    data() {
        return {
            Profile: {}
        };
    },
    beforeCreate() {
        if (localStorage.token) {
            axios
                .get("/api/user", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("token")
                    }
                })
                .then(response => {
                    this.$store.commit("main/loginUser");
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
                        this.$router.push({ name: "login" });
                    }
                });
        }
    }
};
</script>
