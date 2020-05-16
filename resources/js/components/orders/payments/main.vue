<template>
    <div>
        <v-dialog v-model="dialog" persistent width="900">
            <template v-slot:activator="{ on }">
                <v-list-item class="yellow darken-1" v-on="on">
                    <v-list-item-icon>
                        <v-badge
                            color="primary"
                            dot
                            :value="count.slipNotVerifyOnly"
                        >
                            <v-icon class="black--text">attach_money</v-icon>
                        </v-badge>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="black--text py-1">
                            การชำระเงิน
                        </v-list-item-title>
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
                    <v-row
                        class="px-4 mb-4"
                        v-if="
                            this.$store.getters['order/getByID'].sum.balance !=
                                0
                        "
                    >
                        <acceptPayment
                            class="mr-2"
                            :sum="this.$store.getters['order/getByID'].sum"
                        ></acceptPayment>
                        <tablePaymentVerify
                            class="mr-2"
                            :slips="
                                this.$store.getters['order/getByID'].data
                                    .slip_not_verify
                            "
                            v-if="
                                this.$store.getters['order/getByID'].count
                                    .slipNotVerify
                            "
                        ></tablePaymentVerify>
                        <alertPayment class="mr-2"></alertPayment>
                        <notPayDeposit
                            v-if="
                                this.$store.getters['order/getByID'].data
                                    .order_status_id == 2 ||
                                    this.$store.getters['order/getByID'].data
                                        .order_status_id == 3
                            "
                        ></notPayDeposit>
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
import tablePaymentVerify from "@/js/components/orders/payments/tablePaymentVerify";
import acceptPayment from "@/js/components/orders/payments/acceptPayment";
import tablePayment from "@/js/components/orders/payments/tablePayment";
import notPayDeposit from "@/js/components/orders/payments/notPayDeposit";

export default {
    props: ["count"],
    components: {
        alertPayment,
        acceptPayment,
        tablePayment,
        tablePaymentVerify,
        notPayDeposit
    },
    data() {
        return {
            dialog: false
        };
    }
};
</script>

<style></style>
