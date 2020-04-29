<template>
    <div>
        <v-dialog v-model="dialog" persistent width="900">
            <template v-slot:activator="{ on }">
                <v-list-item class="yellow darken-1" v-on="on">
                    <v-list-item-icon>
                        <v-icon class="black--text">attach_money</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="black--text"
                            >ชำระเงิน</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-card color="#121212">
                <v-card-title>
                    การชำระเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-row class="px-4 mb-4">
                        <acceptPayment
                            class="mr-2"
                            :sum="this.$store.getters['order/getByID'].sum"
                        ></acceptPayment>
                        <acceptPaymentFormAlert class="mr-2" :slips="this.$store.getters['order/getByID'].data.slip"></acceptPaymentFormAlert>
                        <alertPayment></alertPayment>
                    </v-row>
                    <tablePayment
                        :payments="
                            this.$store.getters['order/getByID'].data
                                .order_payment
                        "
                    ></tablePayment>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import alertPayment from "@/js/components/orders/payments/alertPayment";
import acceptPaymentFormAlert from "@/js/components/orders/payments/acceptPaymentFormAlert";
import acceptPayment from "@/js/components/orders/payments/acceptPayment";
import tablePayment from "@/js/components/orders/payments/tablePayment";

export default {
    props: [],
    components: {
        alertPayment,
        acceptPayment,
        tablePayment,
        acceptPaymentFormAlert
    },
    data() {
        return {
            dialog: false
        };
    }
};
</script>

<style></style>
