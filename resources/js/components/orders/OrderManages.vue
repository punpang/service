<template>
    <div>
        <v-dialog v-model="dialog" width="1250" persistent>
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
                <v-card-text class="px-4">
                    <v-row>
                        <v-col cols="12" md="3">
                            <v-card>
                                <v-card-title>
                                    รายการสั่งซื้อ
                                    <v-spacer></v-spacer>
                                    #{{ order.id }}0582
                                </v-card-title>
                                <v-divider class="ma-1"></v-divider>
                                <v-card-text class="px-0 pt-0">
                                    <v-container class="py-0">
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
                            <OrderShow
                                @emitClickMenu="emitClickMenu"
                            ></OrderShow>
                        </v-col>
                        <v-col cols="12" md="3" v-show="menu">
                            <OrderMenuForManages
                                :order="order"
                                @emitDialogOff="emitDialogOff"
                            ></OrderMenuForManages>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
            <overlay :overlay="overlay"></overlay>
        </v-dialog>
    </div>
</template>

<script>
import OrderMenuForManages from "@/js/components/orders/OrderMenuForManages";
import OrderShow from "@/js/components/orders/details/show";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["order"],
    components: {
        OrderMenuForManages,
        OrderShow,
        overlay
    },
    data() {
        return {
            dialog: false,
            menu: true,
            setMDForDetail: 6,
            overlay: false
        };
    },
    methods: {
        async start() {
            this.overlay = true;
            await this.$store.dispatch(
                "orderDetail/getByOrderID",
                this.order.id
            );
            this.overlay = false;
        },
        emitClickMenu(value) {
            this.menu = !this.menu;
            if (this.menu) {
                this.setMDForDetail = 6;
            } else {
                this.setMDForDetail = 8;
            }
        },
        async emitDialogOff() {
            await this.$store.dispatch("orderDetail/getByOrderIDReset");
            this.dialog = false;
        }
    }
};
</script>

<style></style>
