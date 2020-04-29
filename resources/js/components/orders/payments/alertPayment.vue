<template>
    <div>
        <v-dialog v-model="dialog" persistent width="350">
            <template v-slot:activator="{ on }">
                <v-btn color="warning" v-on="on">แจ้งชำระเงิน</v-btn>
            </template>
            <v-card color="#121212">
                <v-card-title>
                    แจ้งชำระเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <CostSub
                        :sum="this.$store.getters['order/getByID'].sum"
                    ></CostSub>
                    <v-divider class="ma-0"></v-divider>
                    <v-form ref="form" lazy-validation>
                        <v-select
                            :items="deposits"
                            item-text="text"
                            item-value="value"
                            v-model="deposit"
                            label="ยอดชำระขั้นต่ำ"
                            hide-details
                            outlined
                            class="py-4"
                            :rules="[v => !!v]"
                            @change="changeDeposit(deposit)"
                        ></v-select>

                        <v-text-field
                            label="จำนวนเงิน"
                            outlined
                            pattern="\d*"
                            hide-details
                            v-model="form.amount"
                            :disabled="deposit != 0"
                            v-currency
                            :rules="[v => !!v]"
                            suffix="บาท"
                        ></v-text-field>
                    </v-form>
                    <v-btn
                        color="success"
                        large
                        class="my-4"
                        @click="clickSubmit"
                    >
                        <v-icon left>attach_money</v-icon>
                        แจ้งการชำระเงิน
                    </v-btn>

                    <v-btn color="error" large>
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
    components: {
        CostSub,
        overlay
    },
    data() {
        return {
            dialog: false,
            overlay: false,
            deposits: [
                { value: "0.5", text: "50 เปอร์เซนต์" },
                { value: "1", text: "ชำระทั้งหมด" },
                { value: "0", text: "กำหนดอง" }
            ],
            deposit: "0.5",
            form: {
                order_id: this.$store.getters["order/getByID"].data.id,
                amount: "0"
            }
        };
    },
    methods: {
        changeDeposit(value) {
            this.form.amount =
                this.$store.getters["order/getByID"].sum.balance * value;
        },
        async clickSubmit() {
            this.overlay = true;
            if (this.$refs.form.validate()) {
                const res = await this.$store.dispatch(
                    "payment/alert",
                    this.form
                );

                if (res.status === 200) {
                    this.dialog = false;
                }
            }
            this.overlay = false;
        }
    },
    mounted() {
        this.changeDeposit(this.deposit);
    }
};
</script>

<style></style>
