<template>
    <div>
        <v-card class="mb-4">
            <v-card-title>
                <h2 class="mb-0">สร้างรายการสั่งซื้อใหม่</h2>
            </v-card-title>
        </v-card>
        <v-row class="mb-1">
            <v-col cols="12" md="4" sm="6">
                <customerShow
                    @emitCountSetTemp="emitCountSetTemp"
                ></customerShow>
            </v-col>
            <v-col cols="12" md="4" sm="6">
                <dataTimeGetShow
                    :propCountSetTemp="countSetTemp"
                ></dataTimeGetShow>
            </v-col>
            <v-col cols="12" md="4" sm="12">
                <orderChannelShow
                    :propDataSuccess="dataSuccess"
                ></orderChannelShow>
            </v-col>
        </v-row>

        <v-card v-if="dataSuccess" class="mb-4">
            <v-card-title class="text-h6">
                รายการสั่งซื้อ
                <v-spacer></v-spacer>
                <cardManageCake></cardManageCake>
            </v-card-title>
        </v-card>
        <!-- {{ dataSuccess() }} -->

        <tableListProductSelected v-if="dataSuccess"></tableListProductSelected>
        <v-row v-if="dataSuccess">
            <!-- <v-col cols="12" md="4">
                <v-card
                    :height="heightAddProduct"
                    class="d-flex align-center text-center"
                >
                    <v-card-text>
                        <productSelectCake></productSelectCake>
                    </v-card-text>
                </v-card>
            </v-col> -->

            <v-col
                cols="12"
                md="4"
                sm="6"
                v-for="{ temp, index } in detailTemps"
                :key="index"
            >
                <v-card height="100%">
                    <v-card-text>
                        {{ temp }}
                        <v-row>
                            <v-col cols="12">
                                <v-img
                                    src="https://www.punpangsv.com/admin_system/home/product/img-products/3FE0FF85-F7DE-4ED2-A5EF-77C4955186C1_1_201_a.png"
                                ></v-img>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-h6 mb-1 font-weight-black">
                                    {{ msg.text.detailProduct }}
                                </p>
                                <p :class="msg.text.op1"></p>
                                <v-simple-table>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                {{ temp.data.name_goods }}
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td>{{ msg.text.op1 }}</td>
                                            <td class="text-right">
                                                {{ temp.am1.m1 }}
                                            </td>
                                        </tr> -->
                                        <!-- // -->
                                        <!-- <tr>
                                            <td>{{ msg.text.op2 }}</td>
                                            <td class="text-right">
                                                {{ temp.am2.m2 }}
                                            </td>
                                        </tr> -->
                                        <!-- // -->
                                        <!-- <tr>
                                            <td>{{ msg.text.op3 }}</td>
                                            <td class="text-right">
                                                {{ temp.am3.m3 }}
                                            </td>
                                        </tr> -->
                                        <!-- // -->
                                        <!-- <tr>
                                            <td>{{ msg.text.op4 }}</td>
                                            <td class="text-right">
                                                {{ temp.am4.m4 }}
                                            </td>
                                        </tr> -->
                                        <!-- // -->
                                        <tr>
                                            <td>{{ msg.text.price }}</td>
                                            <td class="text-right">
                                                {{ temp.price | formatNumber }}
                                            </td>
                                        </tr>
                                        <!-- // -->
                                        <tr v-if="temp.message != '-'">
                                            <td colspan="2">
                                                <p class="my-2">
                                                    <strong>{{
                                                        msg.text.message
                                                    }}</strong>
                                                </p>
                                                <p class="subtitle-2 mb-2 pl-3">
                                                    {{ temp.message }}
                                                </p>
                                            </td>
                                        </tr>
                                        <!-- // -->
                                        <tr v-if="temp.detail != '-'">
                                            <td colspan="2">
                                                <p class="my-2">
                                                    <strong>{{
                                                        msg.text.detail
                                                    }}</strong>
                                                </p>
                                                <p class="subtitle-2 mb-2 pl-3">
                                                    {{ temp.detail }}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-h6 mb-1 font-weight-black">
                                    {{ msg.text.moreOptions }}
                                </p>
                                <v-simple-table>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                moreOption, index
                                            ) in temp.moreOptions"
                                            :key="index"
                                        >
                                            <td>+ {{ moreOption.title }}</td>
                                            <td class="text-right">
                                                {{
                                                    moreOption.price
                                                        | formatNumber
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right">
                                                <strong>70.00</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-col>
                            <v-col cols="12" md="3"></v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <!-- // -->
        </v-row>

        <v-bottom-navigation
            app
            class="yellow darken-4"
            v-if="dataSuccess && detailTemps.length > 0"
        >
            <btnNewOrderCake class="mt-2"></btnNewOrderCake>
        </v-bottom-navigation>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import customerShow from "@/js/components/order/customer/cardShow/show";
import dataTimeGetShow from "@/js/components/order/dataTimeGet/cardShow/show";
import orderChannelShow from "@/js/components/order/orderChannel/show";
import productSelectCake from "@/js/components/order/product/select/cake";
import cardManageCake from "@/js/components/order/cardManageCake";
import btnNewOrderCake from "@/js/components/order/btnNewOrderCake";
import tableListProductSelected from "@/js/components/order/tableListProductSelected";

export default {
    components: {
        customerShow,
        dataTimeGetShow,
        orderChannelShow,
        productSelectCake,
        cardManageCake,
        tableListProductSelected,
        btnNewOrderCake,
    },
    data() {
        return {
            countSetTemp: 0,
            dateTimeGet: {
                dateGet: "",
                timeGet: "",
            },
            channel: "",
            products: [],
            classDetailProduct: "text-subtitle-1 mb-1 ml-4",
        };
    },
    methods: {
        emitCountSetTemp() {
            this.countSetTemp = 1;
        },
        // emitProducts(v) {
        //     this.products.push(v);
        // },
        save() {
            if (!this.dataSuccess) {
                this.$toast.error("ไม่ผ่าน");
                return;
            }
            const data = {
                customer: this.customer,
                dateTimeGet: this.dateTimeGet,
                channel: this.channel,
                orders: {},
            };

            // console.log(data);
        },
        async setOrderTemp() {
            this.countSetTemp = this.countSetTemp + 1;
            if (this.temp.id == "" && this.countSetTemp === 1) {
                const payload = {
                    customer: this.customer,
                    temp: this.temp.temp,
                };
                await this.$store.dispatch("orderTemp/setTemp", payload);
                this.$store.dispatch("orderTemp/fetch", {
                    customer: this.customer,
                });
            } else if (this.countSetTemp >= 2) {
                const payload = {
                    customer: this.customer,
                    temp: this.temp.temp,
                };
                await this.$store.dispatch("orderTemp/setTemp", payload);
            }
        },
    },
    mounted() {
        this.products = [
            // {
            //   id: 388,
            //   code: 1111,
            //   price: 200,
            //   m1: 1,
            //   m2: 1,
            //   m3: 1,
            //   m4: 1,
            //   created_at: "2021-09-04 14:35:25",
            //   updated_at: "2021-09-05 10:30:32",
            //   am1: { id: 1, m1: "ครีมนมสด" },
            //   am2: { id: 1, m2: "วานิลลา" },
            //   am3: { id: 1, m3: "ธรรมดา" },
            //   am4: { id: 1, m4: "1 ปอนด์", count: 1 },
            //   message: "-",
            //   detail: "-",
            //   moreOptions: [{ id: 1, title: "แยมมะพร้าวอ่อน", price: 70, size: 1 }],
            // },
            // {
            //   id: 388,
            //   code: 1111,
            //   price: 200,
            //   m1: 1,
            //   m2: 1,
            //   m3: 1,
            //   m4: 1,
            //   created_at: "2021-09-04 14:35:25",
            //   updated_at: "2021-09-05 10:30:32",
            //   am1: { id: 1, m1: "ครีมนมสด" },
            //   am2: { id: 1, m2: "วานิลลา" },
            //   am3: { id: 1, m3: "ธรรมดา" },
            //   am4: { id: 1, m4: "1 ปอนด์", count: 1 },
            //   message: "fdsfdsfdsfdsfdsfdsfdsfds",
            //   detail: "-เพิ่มหมา -เพิ่มแมว -จัดส่ง(40) -ช็อกหน้านิ่ม -วานิลลา",
            // },
        ];
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            detailTemps: "orderDetailTemp/temps",
            temp: "orderTemp/temp",
            customer: "orderCustomer/getSearch",
        }),
        dataSuccess() {
            if (!this.customer) return false;
            if (
                !this.temp.temp.dateTimeGet.dateGet ||
                !this.temp.temp.dateTimeGet.timeGet
            )
                return false;
            if (!this.temp.temp.channel) return false;

            this.setOrderTemp();
            return true;
        },
        heightAddProduct() {
            if (this.detailTemps.length > 0) {
                return "100%";
            }
            return 250;
        },
    },
};
</script>

<style></style>
