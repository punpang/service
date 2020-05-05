<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            width="350"
            v-if="sum.balance > 0"
        >
            <template v-slot:activator="{ on }">
                <v-btn color="success" v-on="on">รับชำระเงิน</v-btn>
            </template>
            <v-card color="#121212">
                <v-card-title>
                    รับชำระเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="emitExit">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <CostSub
                        :sum="this.$store.getters['order/getByID'].sum"
                    ></CostSub>
                    <v-divider class="ma-0"></v-divider>
                    <formPayment
                        :sum="this.$store.getters['order/getByID'].sum"
                        :form="form"
                        @emitExit="emitExit"
                    ></formPayment>
                </v-card-text>
            </v-card>
            <overlay :overlay="overlay"></overlay>
        </v-dialog>
    </div>
</template>

<script>
import CostSub from "@/js/components/orders/details/CostSub";
import formPayment from "@/js/components/orders/payments/_form_payment";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["sum"],
    components: {
        CostSub,
        overlay,
        formPayment
    },
    data() {
        return {
            dialog: false,
            response: {},
            overlay: false,
            form: {
                order_id: this.$store.getters["order/getByID"].data.id,
                order_payment_method_id: 1,
                amount: "0",
                status: 1,
                alert: true,
            }
        };
    },
    methods: {
        emitExit() {
            this.dialog = false;
        }
    },
};
</script>

<style></style>
