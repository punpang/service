<template>
    <div>
        <v-dialog v-model="dialog" persistent width="350">
            <template v-slot:activator="{ on }">
                <v-btn color="error" v-on="on" small @click="start" :disabled="payment.status === 0">
                    <v-icon left>cancel</v-icon>
                    ยกเลิกรายการ
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ยกเลิกการชำระเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6" md="6">คำสั่งซื้อ</v-col>
                        <v-col cols="6" md="6" class="text-right"
                            >#{{ payment.order_id }}</v-col
                        >
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">ช่องทางการชำระเงิน</v-col>
                        <v-col cols="6" md="6" class="text-right"
                            >{{ payment.order_payment_method.name }}</v-col
                        >
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">เลขที่ใบเสร็จ</v-col>
                        <v-col cols="6" md="6" class="text-right"
                            >#{{ payment.bill_id }}</v-col
                        >
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">สถานะ</v-col>
                        <v-col cols="6" md="6" class="text-right py-2">
                            <setStautsColorText
                                :status="payment.status"
                            ></setStautsColorText>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">วัน-เวลาทำรายการ</v-col>
                        <v-col cols="6" md="6" class="text-right">
                            {{ payment.updated_at }}
                        </v-col>
                    </v-row>
                    <v-alert type="warning"
                        >ต้องการยกเลิกรายการใช่ไหม ?</v-alert
                    >
                    <v-form ref="form" lazy-validation>
                        <v-text-field
                            outlined
                            label="โปรดกรอกคำนวน 'ยกเลิก' ลงในช่อง"
                            :rules="[v => v == 'ยกเลิก']"
                            hide-details
                            class="mb-4"
                        ></v-text-field>
                    </v-form>

                    <v-btn color="error" large @click="clickCancelPayment">
                        <v-icon left>delete</v-icon>
                        ยกเลิกรายการ
                    </v-btn>
                    <v-btn color="primary" large @click="dialog = false">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                </v-card-text>
            </v-card>
            <overlay :overlay="overlay"></overlay>
            <snackbarRight :snackbar="snackbar"></snackbarRight>
        </v-dialog>
    </div>
</template>

<script>
import setStautsColorText from "@/js/components/orders/payments/setStautsColorText";
import overlay from "@/js/layouts/overlay";
import snackbarRight from "@/js/layouts/snackbarRight";

export default {
    props: ["payment"],
    components: {
        setStautsColorText,
        overlay
    },
    data() {
        return {
            dialog: false,
            overlay: false,
            snackbar: {
                status: false
            }
        };
    },
    methods: {
        start(){
            this.$refs.form.reset();
        },
        async clickCancelPayment() {
            this.overlay = true;
            if (this.$refs.form.validate()) {
                const res = await this.$store.dispatch(
                    "payment/cancel",
                    this.payment.id
                );

                await this.$store.dispatch("order/getByID", this.payment.order_id);

                if (res.status == 200) {
                    this.snackbar = {
                        status: true,
                        color: "success",
                        text: res.data.message
                    };
                    this.$refs.form.reset();

                    this.dialog = false;
                } else if (res.status == 201) {
                    this.snackbar = {
                        status: true,
                        color: "warning",
                        text: res.data.message
                    };
                    this.dialog = false;
                    this.$refs.form.reset();
                    this.overlay = false;
                }

                this.snackbar = {
                    status: true,
                    color: "error",
                    text: "กรุณาลองอีกครั้ง ผิดพลาดบางอย่าง"
                };

                this.overlay = false;
            } else {
                this.overlay = false;
                this.snackbar = {
                    status: true,
                    color: "error",
                    text: "กรุณาลองอีกครั้ง ผิดพลาดบางอย่าง"
                };
            }
        }
    }
};
</script>

<style></style>
