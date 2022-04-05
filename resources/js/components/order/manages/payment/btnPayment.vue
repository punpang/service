<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            width="100%"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-title> การชำระเงิน </v-list-item-title>
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
    },
};
</script>
