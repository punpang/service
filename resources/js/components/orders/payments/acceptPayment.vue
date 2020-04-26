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
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <CostSub
                        :sum="this.$store.getters['orderDetail/sum']"
                    ></CostSub>
                    <v-divider class="ma-0"></v-divider>
                    <v-row>
                        <v-col cols="6" md="6" class="pt-4"
                            >ช่องทางการชำระ</v-col
                        >
                        <v-col cols="6" md="6" class="text-right">เงินสด</v-col>
                    </v-row>

                    <v-row v-if="sum.balance > 0">
                        <v-col cols="6" md="6" class="pt-4">ชำระครั้งนี้</v-col>
                        <v-col cols="6" md="6">
                            <v-form ref="form" lazy-validation>
                                <v-text-field
                                    v-model="form.amount"
                                    :rules="[v => !!v]"
                                    hide-details
                                    autocomplete="false"
                                    pattern="\d*"
                                    class="ma-0 pa-0"
                                    autofocus
                                    suffix="บาท"
                                    v-currency
                                ></v-text-field>
                            </v-form>
                        </v-col>
                    </v-row>
                    <v-row class="py-1" v-show="form.amount - sum.balance > 0">
                        <v-col cols="6" md="6">เงินทอน</v-col>
                        <v-col cols="6" md="6" class="text-right">
                            {{ form.amount - sum.balance }}.00 บาท
                        </v-col>
                    </v-row>
                    <v-divider class="ma-0"></v-divider>
                    <v-checkbox
                        label="แจ้งผ่านข้อความ"
                        v-model="form.AlertSMS"
                    ></v-checkbox>
                    <v-btn color="success" @click="clickSubmit">
                        <v-icon left>attach_money</v-icon>
                        ชำระเงิน
                    </v-btn>

                    <v-btn color="error" @click="dialog = false">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                </v-card-text>
            </v-card>
            <overlay :overlay="overlay"></overlay>
        </v-dialog>
    </div>
</template>

<script>
import CostSub from "@/js/components/orders/details/CostSub";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["sum"],
    components: {
        CostSub,
        overlay
    },
    data() {
        return {
            dialog: false,
            sum_price: this.sum.total,
            response: {},
            balance: "",
            overlay: false,
            form: {
                order_id: this.$store.getters["order/selected"].id,
                payment_method_id: 1,
                amount: "",
                status: 1,
                AlertSMS: true
            }
        };
    },
    methods: {
        async clickSubmit() {
            if (this.$refs.form.validate()) {
                this.overlay = true;
                this.response = await this.$store.dispatch(
                    "payment/create",
                    this.form
                );

                await this.$store.dispatch(
                    "orderDetail/getByOrderID",
                    this.form.order_id
                );

                if (this.response.status == 200) {
                    this.dialog = false;
                    this.overlay = false;
                }
                console.log("acceptPayment", this.response);
            } else {
            }
        },
        setBalance() {
            this.balance = this.form.amount - this.sum.NoFormat.balance;
        }
    }
};
</script>

<style></style>
