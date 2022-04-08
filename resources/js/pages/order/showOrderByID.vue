<template>
    <div>
        <v-row>
            <v-col cols="12" md="8">
                <cardManagesGoodsDetail></cardManagesGoodsDetail>
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
                    <v-subheader>สินค้า</v-subheader>
                    <btnAddGoods></btnAddGoods>
                    <v-subheader>เปลี่ยนแปลงข้อมูล</v-subheader>
                    <btnChangeCustomer></btnChangeCustomer>
                    <v-subheader>การชำระเงิน</v-subheader>
                    <btnAlertPayment></btnAlertPayment>
                    <btnPayment></btnPayment>
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

import btnAddGoods from "@/js/components/order/addGoods/btnAddGoods";
import btnAlertPayment from "@/js/components/order/manages/alertPayment/btnAlertPayment";
import btnPayment from "@/js/components/order/manages/payment/btnPayment";
import btnChangeCustomer from "@/js/components/order/changeCustomer/btnChangeCustomer";

export default {
    components: {
        cardDataCustomer,
        cardDataOrderDetail,

        cardManagesGoodsDetail,
        cardPaymentSummary,

        btnAddGoods,
        btnAlertPayment,
        btnPayment,
        btnChangeCustomer,
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
            const payload = {
                orderID: this.$route.params.id,
            };
            this.$store.dispatch("orderIndex/getOrderByID", payload);
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
        }),
    },
};
</script>
