<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
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
                            :sum="this.$store.getters['orderDetail/sum']"
                        ></acceptPayment>
                        <alertCost></alertCost>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import alertCost from "@/js/components/orders/payments/alertCost";
import acceptPayment from "@/js/components/orders/payments/acceptPayment";

export default {
    props: [],
    components: {
        alertCost,
        acceptPayment
    },
    data() {
        return {
            dialog: false,
        };
    }
};
</script>

<style></style>
