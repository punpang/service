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
                    <v-icon color="error" @click="clickExit">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <CostSub
                        :sum="this.$store.getters['order/getByID'].sum"
                    ></CostSub>
                    <v-divider class="ma-0"></v-divider>
                    <v-form ref="form" lazy-validation>
                        <v-row>
                            <v-col cols="6" md="6" class="pt-4"
                                >ช่องทางการชำระ
                                <v-icon
                                    right
                                    color="success"
                                    @click="reloadOrderPaymentMethod"
                                    >refresh</v-icon
                                ></v-col
                            >
                            <v-col cols="6" md="6" class="text-right">
                                <v-select
                                    :items="
                                        this.$store.getters[
                                            'orderPaymentMethod/useonly'
                                        ]
                                    "
                                    class="ma-0 pa-0"
                                    hide-details
                                    item-text="name"
                                    item-value="id"
                                    v-model="form.order_payment_method_id"
                                    :rules="[v => !!v]"
                                ></v-select>
                            </v-col>
                        </v-row>

                        <v-row v-if="sum.balance > 0">
                            <v-col cols="6" md="6" class="pt-4"
                                >ชำระครั้งนี้</v-col
                            >
                            <v-col cols="6" md="6">
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
                            </v-col>
                        </v-row>
                    </v-form>
                    <v-row class="py-1" v-show="form.amount - sum.balance > 0">
                        <v-col cols="6" md="6">เงินทอน</v-col>
                        <v-col cols="6" md="6" class="text-right">
                            {{ setMoneyBack(form.amount, sum.balance) }} บาท
                        </v-col>
                    </v-row>
                    <v-divider class="ma-0"></v-divider>
                    <v-checkbox
                        label="แจ้งผ่านข้อความ"
                        v-model="form.alert"
                    ></v-checkbox>
                    <v-btn color="success" @click="clickSubmit">
                        <v-icon left>attach_money</v-icon>
                        ชำระเงิน
                    </v-btn>

                    <v-btn color="error" @click="clickExit">
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
            response: {},
            overlay: false,
            form: {
                order_id: this.$store.getters["order/getByID"].data.id,
                order_payment_method_id: "",
                amount: "",
                status: 1,
                alert: true
            }
        };
    },
    methods: {
        async reloadOrderPaymentMethod() {
            await this.$store.dispatch("orderPaymentMethod/useonly");
            this.form.order_payment_method_id =""
        },
        async clickSubmit() {
            if (this.$refs.form.validate()) {
                this.overlay = true;
                this.response = await this.$store.dispatch(
                    "payment/create",
                    this.form
                );

                await this.$store.dispatch(
                    "order/getByID",
                    this.$store.getters["order/getByID"].data.id
                );

                if (this.response.status == 200) {
                    this.dialog = false;
                    this.overlay = false;
                    this.reset();
                }
            } else {
            }
        },
        clickExit() {
            this.reset();
            this.dialog = false;
        },
        reset() {
            this.$refs.form.reset();
        },
        setMoneyBack(a, b) {
            return a - b;
        }
    },

    mounted() {
        this.reloadOrderPaymentMethod();
    }
};
</script>

<style></style>
