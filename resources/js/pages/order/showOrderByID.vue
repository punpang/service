<template>
    <div>
        <alertAdjustExcessPayment
            v-if="order.sum_all.sumBalance < 0"
        ></alertAdjustExcessPayment>
        <v-row>
            <v-col cols="12" md="8">
                <cardManagesGoodsDetail></cardManagesGoodsDetail>
                <cardDeliveryShow></cardDeliveryShow>
            </v-col>
            <v-col cols="12" md="4">
                <cardDataCustomer></cardDataCustomer>
                <cardDataOrderDetail></cardDataOrderDetail>
                <cardPaymentSummary></cardPaymentSummary>
            </v-col>

            <v-col cols="12" md="3"></v-col>
        </v-row>
        <v-bottom-navigation app class="warning">
            <v-bottom-sheet v-model="sheet">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on">
                        <div class="white--text text-h6">
                            <v-icon large>more_vert</v-icon>
                            การจัดการ
                        </div>
                    </v-btn>
                </template>
                <v-list>
                    <!-- <v-subheader>สินค้า</v-subheader> -->
                    <btnAddGoods v-if="order.status < 8"></btnAddGoods>
                    <!-- <v-subheader>เปลี่ยนแปลงข้อมูล</v-subheader> -->
                    <btnChangeCustomer
                        v-if="order.status < 8"
                    ></btnChangeCustomer>
                    <btnConnectSocialProfile
                        v-if="order.status < 8"
                    ></btnConnectSocialProfile>
                    <btnChangeDateTimeGet
                        v-if="order.status < 8"
                    ></btnChangeDateTimeGet>
                    <!-- <v-subheader>การชำระเงิน</v-subheader> -->
                    <btnAlertPayment
                        v-if="order.sum_all.sumBalance > 0"
                    ></btnAlertPayment>
                    <btnPayment
                        v-if="order.sum_all.sumBalance > 0"
                    ></btnPayment>
                    <!-- <v-subheader></v-subheader> -->
                    <btnDelivery
                        :propButton="'list'"
                        v-if="!order.order_delivery_service && order.status < 8"
                    ></btnDelivery>
                    <btnPrepareGoods></btnPrepareGoods>
                    <btnPickUpGoods></btnPickUpGoods>
                    <!-- <v-list-item v-for="tile in tiles" :key="tile.title">
                        <v-list-item-title>{{ tile.title }}</v-list-item-title>
                    </v-list-item> -->
                </v-list>
            </v-bottom-sheet>
        </v-bottom-navigation>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import cardDataCustomer from "@/js/components/order/cardDataCustomer";
import cardDataOrderDetail from "@/js/components/order/cardDataOrderDetail";
import cardManagesGoodsDetail from "@/js/components/order/cardManagesGoodsDetail";
import cardPaymentSummary from "@/js/components/order/cardPaymentSummary";
import cardDeliveryShow from "@/js/components/order/delivery/show/cardDeliveryShow";

import btnAddGoods from "@/js/components/order/addGoods/btnAddGoods";

import btnAlertPayment from "@/js/components/order/manages/alertPayment/btnAlertPayment";
import btnPayment from "@/js/components/order/manages/payment/btnPayment";
import btnChangeCustomer from "@/js/components/order/changeCustomer/btnChangeCustomer";
import btnConnectSocialProfile from "@/js/components/order/connectSocialProfile.vue/button.vue";
import btnChangeDateTimeGet from "@/js/components/order/changeDateTimeGet/btnChangeDateTimeGet";
import btnDelivery from "@/js/components/order/delivery/btnDelivery";
import btnPrepareGoods from "@/js/components/order/prepareGoods/btnPrepareGoods";
import btnPickUpGoods from "@/js/components/order/pickUpGoods/btnPickUpGoods";

import alertAdjustExcessPayment from "@/js/components/order/adjustExcessPayment/alert";
export default {
    components: {
        cardDataCustomer,
        cardDataOrderDetail,

        cardManagesGoodsDetail,
        cardPaymentSummary,
        cardDeliveryShow,

        btnAddGoods,
        btnConnectSocialProfile,
        btnAlertPayment,
        btnPayment,
        btnChangeCustomer,
        btnChangeDateTimeGet,
        btnDelivery,
        btnPrepareGoods,
        btnPickUpGoods,

        alertAdjustExcessPayment,
    },
    data() {
        return {
            sheet: false,
            tiles: [
                { title: "เพิ่มสินค้า" },
                { title: "การชำระเงิน" },
                { title: "เตรียมสินค้า" },
                { title: "รับสินค้า" },
                { title: "บริการเสริม" },
            ],
        };
    },
    methods: {
        async start() {
            let loader = this.$loading.show();
            const payload = {
                orderID: this.$route.params.id,
            };
            const result = await this.$store.dispatch(
                "orderIndex/getOrderByID",
                payload
            );

            if (result.status != 200) {
                this.$swal({
                    title: "ผิดพลาด",
                    text: "มีบางอย่างขัดข้อง",
                    icon: "error",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            }

            loader.hide();
        },
    },
    async mounted() {
        await this.start();
        // window.Echo.channel("OrderEventOn").listen(".OrderEventAs", (e) => {
        //     const data = e.data;
        //     console.log(data);
        //     if (data.order_id == this.$route.params.id) {
        //         this.$toast.info(`ข้อมูลอัปเดทล่าสุด : ${data.updated_at}`);
        //     }
        // });
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            user: "main/User",
        }),
    },
};
</script>
