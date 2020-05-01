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
                        pattern="\d*"
                        class="ma-0 pa-0"
                        autofocus
                        suffix="บาท"
                        v-currency
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-form>
        <v-row class="py-1">
            <v-col cols="6" md="6">{{
                setText(form.amount, sum.balance)
            }}</v-col>
            <v-col cols="6" md="6" class="text-right">
                {{ setMoneyBack(form.amount, sum.balance) }} บาท
            </v-col>
        </v-row>
        <v-divider class="ma-0"></v-divider>
        <v-checkbox label="แจ้งผ่านข้อความ" v-model="form.alert"></v-checkbox>
        <v-btn
            color="success"
            @click="clickSubmit"
            :disabled="
                (form.order_payment_method_id == 2 &&
                    form.amount - sum.balance > 0) ||
                    alertRefDouble
            "
        >
            <v-icon left>attach_money</v-icon>
            ชำระเงิน
        </v-btn>

        <v-btn
            color="warning"
            v-if="form.order_payment_method_id == 2"
            @click="clickExit"
        >
            <v-icon left>cancel</v-icon>
            ไม่ผ่าน
        </v-btn>

        <v-btn color="error" @click="clickExit">
            <v-icon left>exit_to_app</v-icon>
            ออก
        </v-btn>
        <v-alert type="error" class="mt-2" v-if="alertRefDouble">
            {{ response.data.message }}
        </v-alert>
        <overlay :overlay="overlay"></overlay>
    </div>
</template>

<script>
import CostSub from "@/js/components/orders/details/CostSub";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["sum", "formData"],
    components: {
        CostSub,
        overlay
    },
    data() {
        return {
            dialog: false,
            response: {},
            overlay: false,
            form: this.formData,
            alertRefDouble: false
        };
    },
    methods: {
        async reloadOrderPaymentMethod() {
            await this.$store.dispatch("orderPaymentMethod/useonly");
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
                    this.overlay = false;
                    this.clickExit();
                } else if (this.response.status == 299) {
                    this.alertRefDouble = true;
                    this.overlay = false;
                }
            } else {
            }
        },
        clickExit() {
            this.reset();
            this.$emit("emitExit");
            this.dialog = false;
        },
        reset() {
            this.$refs.form.reset();
        },
        setMoneyBack(a, b) {
            const x = a - b;
            if (x < 0) {
                return x * -1;
            } else {
                return x;
            }
        },
        setText(a, b) {
            const x = a - b;
            if (x < 0) {
                return "ยอดคงเหลือ";
            } else {
                return "เงินทอน";
            }
        }
    },

    mounted() {
        this.reloadOrderPaymentMethod();
    }
};
</script>

<style></style>
