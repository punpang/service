<template>
    <div>
        <v-dialog v-model="dialog" width="1250">
            <template v-slot:activator="{ on }">
                <v-btn
                    block
                    color="primary"
                    v-on="on"
                    class="mb-2"
                    small
                    rounded
                    @click="start"
                    >การจัดการ</v-btn
                >
            </template>
            <v-card color="#121212">
                <v-card-text class="pa-0">
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="3">
                                <v-card>
                                    <v-card-title>
                                        รายการสั่งซื้อ
                                        <v-spacer></v-spacer>
                                        #{{ order.id }}0582
                                    </v-card-title>
                                    <v-divider class="ma-1"></v-divider>
                                    <v-card-text>
                                        <v-container class="pt-1">
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                    class="pb-0"
                                                >
                                                    <b>ชื่อลูกค้า</b>
                                                    <v-spacer></v-spacer>
                                                    {{ order.customer.name }}
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                    class="pb-0"
                                                >
                                                    <b>เบอร์โทรศัพท์</b>
                                                    <v-spacer></v-spacer>
                                                    {{ order.customer.phone }}
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                    class="pb-0"
                                                >
                                                    <b>วัน-เวลารับสินค้า</b>
                                                    <v-spacer></v-spacer>
                                                    {{ order.dateTime_get }}
                                                </v-col>
                                                <v-col
                                                    cols="12"
                                                    md="12"
                                                    class="pb-0"
                                                >
                                                    <b>สถานะ</b>
                                                    <v-spacer></v-spacer>
                                                    <span>{{
                                                        order.order_status.name
                                                    }}</span>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" :md="setMDForDetail">
                                <v-card>
                                    <v-card-title>
                                        รายละเอียด
                                        <v-spacer></v-spacer>
                                        <v-icon @click="clickMenu"
                                            >dehaze</v-icon
                                        >
                                    </v-card-title>
                                    <v-divider class="ma-1"></v-divider>
                                    <v-card-text> </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12" md="2" v-show="menu">
                                <OrderMenuForManages
                                    :order="order"
                                ></OrderMenuForManages>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import OrderMenuForManages from "@/js/components/orders/OrderMenuForManages";
export default {
    props: ["order"],
    components: {
        OrderMenuForManages
    },
    data() {
        return {
            dialog: false,
            menu: true,
            setMDForDetail: 7
        };
    },
    methods: {
        start() {},
        clickMenu() {
            this.menu = !this.menu;
            if (this.menu) {
                this.setMDForDetail = 7;
            } else {
                this.setMDForDetail = 9;
            }
        }
    }
};
</script>

<style></style>
