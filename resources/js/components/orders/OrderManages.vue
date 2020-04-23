<template>
    <div>
        <v-dialog v-model="dialog" fullscreen persistent>
            <template v-slot:activator="{ on }">
                <v-btn block color="primary" v-on="on" small @click="start"
                    >การจัดการ</v-btn
                >
            </template>
            <v-card color="#121212">
                <v-card-text class="px-4">
                    <v-row>
                        <v-col cols="12" md="3">
                            <OrderDetail
                                :order="order"
                                class="mb-4"
                            ></OrderDetail>
                            <OrderCost
                                :cost="this.$store.getters['orderDetail/cost']"
                            ></OrderCost>
                        </v-col>
                        <v-col cols="12" md="6">
                            <OrderShow @emitStart="emitStart"></OrderShow>
                        </v-col>
                        <v-col cols="12" md="3">
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

import OrderCost from "@/js/components/orders/details/costs";
import OrderDetail from "@/js/components/orders/details/detail";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["order"],
    components: {
        OrderMenuForManages,
        OrderShow,
        overlay,
        OrderDetail,
        OrderCost
    },
    data() {
        return {
            dialog: false,
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
        emitStart(value) {
            this.start();
        },
        async emitDialogOff() {
            await this.$store.dispatch("orderDetail/getByOrderIDReset");
            this.dialog = false;
        }
    }
};
</script>

<style></style>
