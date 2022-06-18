<template>
    <div class="text-center">
        <v-card class="mt-5" outlined>
            <v-card-title class="text-h5">
                <v-icon left>face</v-icon>
                เข้าสู่ระบบ
            </v-card-title>
            <v-card-text class="pt-5 pb-10">
                <v-form lazy-validation ref="loginForm">
                    <v-row justify="center">
                        <v-col cols="10" md="4">
                            <v-text-field
                                label="ชื่อผู้ใช้"
                                v-model="email"
                                required
                                autofocus
                                outlined
                                :rules="rules.email"
                                append-icon="account_circle"
                            ></v-text-field>

                            <v-text-field
                                label="รหัสผ่าน"
                                type="password"
                                :rules="rules.password"
                                v-model="password"
                                outlined
                                append-icon="lock"
                            ></v-text-field>

                            <v-btn
                                color="success"
                                @click="submitLogin"
                                block
                                large
                                :loading="loading"
                            >
                                <v-icon left>power_settings_new</v-icon>
                                เข้าสู่ระบบ</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            rules: {
                email: [(v) => !!v || "ห้ามเว้นว่าง"],
                password: [(v) => !!v || "ห้ามเว้นว่าง"],
            },
            loader: null,
            loading: false,
            email: "",
            password: "",
            loginError: false,
        };
    },
    methods: {
        submitLogin() {
            if (this.$refs.loginForm.validate()) {
                this.loading = true;
                this.loginError = false;
                axios
                    .post("/api/auth/login", {
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        // login user, store the token and redirect to dashboard
                        this.$store.commit("main/loginUser");
                        localStorage.setItem(
                            "token",
                            response.data.access_token
                        );
                        // ค่าเริ่มต้น headers auth
                        axios.defaults.headers.common["Authorization"] =
                            "Bearer " + localStorage.getItem("token");
                        //
                        axios
                            .get("/api/user", {
                                headers: {
                                    Authorization:
                                        "Bearer " +
                                        localStorage.getItem("token"),
                                },
                            })
                            .then((res) => {
                                this.$store.commit("main/User", res.data);
                                this.$store.dispatch("menuBar/lists");
                                if (this.$route.query.from == null) {
                                    this.$router.replace("/home");
                                }
                                this.$router.replace(this.$route.query.from);
                            });
                    })
                    .catch((error) => {
                        if (error.response.status == "500") {
                            this.$toast.warning(
                                "ลองอีกครั้ง ! ไม่สามารถเชิ่อมต่อไปยังเซิร์ฟเวอร์ได้"
                            );
                        } else {
                            this.$toast.error(
                                "ไม่สามารถเข้าสู่ระบบได้ กรุณาลองอีกครั้งค่ะ"
                            );
                        }
                        this.loginError = true;
                        this.loading = false;
                    });
            }
        },
    },
    async mounted() {
        if (this.isLoggedIn) {
            this.$router.replace("/admin");
        }
    },
    computed: {
        ...mapGetters({
            isLoggedIn: "main/isLoggedIn",
        }),
    },
};
</script>

<style scoped>
.form-wrapper {
    min-height: 100%;
    min-height: 100vh;
    display: flex;
    align-items: center;
}
.form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
}
.form-signin .form-control:focus {
    z-index: 2;
}
.form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>
