<template>
    <div>
        <v-dialog v-model="dialog" fullscreen persistent>
            <template v-slot:activator="{ on }">
                <v-btn block color="primary" v-on="on" @click="start">
                    <v-badge
                        color="warning"
                        dot
                        :value="order.slip_not_verify_only.length"
                    >
                        การจัดการ
                    </v-badge>
                </v-btn>
            </template>
            <v-card color="#121212">
                <v-card-text class="px-4">
                    <v-row>
                        <v-col cols="12" md="3">
                            <OrderDetailHead
                                :order="
                                    this.$store.getters['order/getByID'].data
                                "
                                class="mb-4"
                            ></OrderDetailHead>
                            <OrderCostMain
                                :sum="this.$store.getters['order/getByID'].sum"
                            ></OrderCostMain>
                        </v-col>
                        <v-col cols="12" md="6">
                            <OrderShow
                                @emitStart="emitStart"
                                :orderStatusID="order.order_status_id"
                                :details="
                                    this.$store.getters['order/getByID'].data
                                        .order_detail
                                "
                                :count="
                                    this.$store.getters['order/getByID'].count
                                        .product.use
                                "
                                :detailsNo="
                                    this.$store.getters['order/getByID'].data
                                        .order_detail_no_use
                                "
                                :countNo="
                                    this.$store.getters['order/getByID'].count
                                        .product.nouse
                                "
                            ></OrderShow>
                        </v-col>
                        <v-col cols="12" md="3">
                            <OrderMenuForManages
                                :order="
                                    this.$store.getters['order/getByID'].data
                                "
                                :count="
                                    this.$store.getters['order/getByID'].count
                                "
                                :sum="this.$store.getters['order/getByID'].sum"
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

import OrderCostMain from "@/js/components/orders/details/CostMain";
import OrderDetailHead from "@/js/components/orders/details/detailHead";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["order"],
    components: {
        OrderMenuForManages,
        OrderShow,
        overlay,
        OrderDetailHead,
        OrderCostMain
    },
    data() {
        return {
            dialog: false,
            overlay: false,
            data: []
        };
    },
    methods: {
        async start() {
            this.overlay = true;
            await this.$store.dispatch("order/getByID", this.order.id);

            //await this.$store.commit("order/selected", this.order);
            this.overlay = false;
        },
        emitStart(value) {
            this.start();
        },
        async emitDialogOff() {
            this.$emit("emitDialogTableFalse");
            this.dialog = false;
        }
    }
};
</script>

<style></style>
