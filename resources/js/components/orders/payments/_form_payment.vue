<template>
    <div>
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
                            this.$store.getters['orderPaymentMethod/useonly']
                        "
                        class="ma-0 pa-0"
                        hide-details
                        item-text="name"
                        item-value="id"
                        readonly
                        v-model="form.order_payment_method_id"
                        :rules="[v => !!v]"
                    ></v-select>
                </v-col>
            </v-row>
            <v-row v-if="form.order_payment_method_id == 2">
                <v-col cols="6" md="6" class="pt-4">อ้างอิง</v-col>
                <v-col cols="6" md="6">
                    <v-text-field
                        v-model="form.slip_ref"
                        :rules="[v => !!v]"
                        hide-details
                        readonly
                        class="ma-0 pa-0"
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row v-if="sum.balance > 0">
                <v-col cols="6" md="6" class="pt-4">ชำระครั้งนี้</v-col>
                <v-col cols="6" md="6">
                    <v-text-field
                        v-model="form.amount"
                        :rules="[v => !!v]"
                        hide-details
                        autocomplete="false"
                        v-currency
                        pattern="\d*"
                        class="ma-0 pa-0"
                        suffix="บาท"
                    ></v-text-field>
                    {{ setMoneyBack(form.amount, sum.balance) }}
                </v-col>
            </v-row>
        </v-form>
        <v-row class="py-1" v-if="moneyBack.number != 0">
            <v-col cols="6" md="6">{{ moneyBack.text }}</v-col>
            <v-col cols="6" md="6" class="text-right">
                {{ moneyBack.number }} บาท
            </v-col>
        </v-row>
        <v-divider class="ma-0"></v-divider>
        <v-checkbox label="แจ้งผ่านข้อความ" v-model="form.alert"></v-checkbox>
        <v-row class="px-4">
            <v-btn
                v-if="!alertRefDouble"
                class="mr-2"
                color="success"
                @click="clickSubmit"
                :disabled="
                    (moneyBack.numberNot > 0 &&
                        form.order_payment_method_id == 2) ||
                        form.amount <= 0
                "
            >
                <v-icon left>attach_money</v-icon>
                ชำระเงิน
            </v-btn>

            <unVerifyPayment
                class="mr-2"
                v-if="form.order_payment_method_id == 2"
                :form="form"
                @emitExit="clickExit"
            ></unVerifyPayment>

            <v-btn color="error" @click="clickExit">
                <v-icon left>exit_to_app</v-icon>
                ออก
            </v-btn>
        </v-row>

        <overlay :overlay="overlay"></overlay>
    </div>
</template>

<script>
import CostSub from "@/js/components/orders/details/CostSub";
import overlay from "@/js/layouts/overlay";
import unVerifyPayment from "@/js/components/orders/payments/unVerifyPayment";

export default {
    props: ["sum", "form"],
    components: {
        CostSub,
        overlay,
        unVerifyPayment
    },
    data() {
        return {
            dialog: false,
            overlay: false,
            alertRefDouble: false,
            moneyBack: {
                text: "",
                number: 0,
                numberNot: ""
            }
        };
    },
    methods: {
        async reloadOrderPaymentMethod() {
            await this.$store.dispatch("orderPaymentMethod/useonly");
        },
        async clickSubmit() {
            if (this.$refs.form.validate()) {
                this.overlay = true;
                let response = {};
                response = await this.$store.dispatch(
                    "payment/create",
                    this.form
                );

                await this.$store.dispatch(
                    "order/getByID",
                    this.$store.getters["order/getByID"].data.id
                );

                if (response.status == 200) {
                    this.clickExit();
                    this.overlay = false;
                    this.$notify({
                        group: "main",
                        type: "success",
                        text: "รับชำระเงินสำเร็จ"
                    });
                } else if (response.status == 299) {
                    this.$notify({
                        group: "main",
                        type: "error",
                        text: response.data.message
                    });
                    this.alertRefDouble = true;
                    this.overlay = false;
                }
            } else {
            }
        },
        clickExit() {
            this.$emit("emitExit");
            this.dialog = false;
            this.reset();
        },
        reset() {
            this.$refs.form.reset();
        },
        setMoneyBack(a, b) {
            if (a) {
                const aSplit = a.split(",");
                let aNew = "";
                for (let i = 0; i < aSplit.length; i++) {
                    aNew = aNew + aSplit[i];
                }
                const x = aNew - b;
                let y = 0;
                if (x < 0) {
                    y = x * -1;
                } else {
                    y = x;
                }
                this.setText(x);
                this.moneyBack.number = y;
                this.moneyBack.numberNot = x;
            }
        },
        setText(x) {
            let y = "";
            if (x < 0) {
                y = "ยอดคงเหลือ";
            } else {
                y = "เงินทอน";
            }
            this.moneyBack.text = y;
        }
    },

    mounted() {
        this.reloadOrderPaymentMethod();
    }
};
</script>

<style></style>
