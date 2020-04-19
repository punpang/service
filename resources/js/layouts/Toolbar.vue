<template>
    <div>
        <v-app-bar app color="orange darken-3" dark>
            <v-app-bar-nav-icon
                @click="drawer = !drawer"
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
        <v-navigation-drawer
            app
            v-if="this.$store.getters['main/isLoggedIn'] == true"
            v-model="drawer"
        >
            <v-dialog v-if="false" v-model="dialog" width="500">
                <template v-slot:activator="{ on }">
                    <v-btn color="info" v-on="on">
                        <v-icon>
                            add
                        </v-icon>
                        เพิ่ม
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title>
                        เพิ่มข้อมูล
                    </v-card-title>
                    <v-card-text>
                        <v-form
                            ref="FormNewOrder"
                            v-model="NewOrder"
                            lazy-validation
                        >
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="form.name"
                                        label="ชื่อลูกค้า"
                                        required
                                        :rules="[v => !!v || 'ห้ามเว้นว่าง']"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="form.phone"
                                        :counter="10"
                                        label="เบอร์โทร"
                                        required
                                        :rules="[
                                            v => !!v || 'ห้ามเว้นว่าง',
                                            v =>
                                                v.length == 10 ||
                                                'กรอกเบอร์โทร 10 หลักเท่านั้น',
                                            v => {
                                                const pattern = /[0]{1}[0-9]{9}/;
                                                return (
                                                    pattern.test(v) ||
                                                    'กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น'
                                                );
                                            }
                                        ]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="success" text @click="New">บันทึก</v-btn>
                        <v-btn color="red" text @click="Reset"
                            >ล้างข้อมูล</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
    </div>
</template>

<script>
export default {
    props: ["Profile"],
    data() {
        return {
            //navbar
            NewOrder: true,
            form: {
                name: "",
                phone: ""
            },
            dialog: false,
            menus: [
                { icon: "home", title: "หน้าแรก", to: "/" },
                { icon: "shopping_basket", title: "รายการสั่งซื้อ", to: "/order" },
                { icon: "person", title: "ลูกค้า", to: "/customer" },
                { icon: "shop", title: "สินค้า", to: "/product" }
            ],
            //toolbar
            drawer: false,
            NewOrder: true,
            form: {
                name: "",
                phone: ""
            },
            dialog: false,
            MenuProfiles: [
                { icon: "exit_to_app", title: "ออกจากระบบ", to: "/logout" }
            ]
        };
    },
    methods: {
        //drawer() {
        //    this.$store.commit("main/drawerMain");
        //},
        New() {
            if (this.$refs.FormNewOrder.validate()) {
                this.$store.commit("addOrder", this.form);
                this.$refs.FormNewOrder.reset();
                this.dialog = false;
            }
        },
        Reset() {
            this.$refs.FormNewOrder.reset();
        }
    }
};
</script>
