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
                <v-list-item v-on="on">
                    <v-list-item-title> แจ้งเตือนชำระเงิน </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <cardAlertPayment
                    @emitAlertPayment="emitAlertPayment"
                ></cardAlertPayment>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardAlertPayment from "@/js/components/order/manages/alertPayment/cardAlertPayment";
export default {
    components: { cardAlertPayment },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitAlertPayment() {
            this.dialog = false;
        },
    },
};
</script>
