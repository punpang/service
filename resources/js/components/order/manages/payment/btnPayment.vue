<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            width="500"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on" @click="clickStart()">
                    <v-list-item-title> รับชำระเงิน </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <v-card-text class="pa-3">
                    <cardPayment
                        @emitExitCardPayment="emitExitCardPayment"
                    ></cardPayment>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardPayment from "@/js/components/order/manages/payment/cardPayment";
import { mapGetters } from "vuex";
export default {
    components: { cardPayment },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitExitCardPayment() {
            this.dialog = false;
        },
        clickStart() {
            if (
                this.order.sum_all.sumMoneyCustomer > 0 ||
                this.order.order_delivery_service
            ) {
                this.$swal({
                    title: "ต้องชำระทั้งหมด",
                    icon: "info",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            }
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
