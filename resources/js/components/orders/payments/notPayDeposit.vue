<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn color="cyan" v-on="on">
                    ไม่ชำระมัดจำ
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ไม่ชำระมัดจำ
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-alert type="error">
                        คุณต้องการแจ้งลูกค้า ไม่ชำระมัดจำใช่หรือไม่ ?
                    </v-alert>
                    <formAlertSms @emitAlert="emitAlert"></formAlertSms>
                    <v-btn class="error" @click="clickSubmit">
                        <v-icon left>gavel</v-icon>
                        ยืนยัน</v-btn
                    >
                    <v-btn class="primary">
                        <v-icon left>exit_to_app</v-icon>
                        ออก</v-btn
                    >
                </v-card-text>
            </v-card>
            <overlay :overlay="overlay"></overlay>
        </v-dialog>
    </div>
</template>

<script>
import formAlertSms from "@/js/components/others/form_alert_sms";
import overlay from "@/js/layouts/overlay";
export default {
    components: {
        formAlertSms,
        overlay
    },
    data() {
        return {
            dialog: false,
            overlay: false,
            form: {
                order_id: this.$store.getters["order/getByID"].data.id,
                alertSMS: true
            }
        };
    },
    methods: {
        async clickSubmit() {
            this.overlay = true;
            const res = await this.$store.dispatch(
                "payment/notPayDeposit",
                this.form
            );
            await this.$store.dispatch(
                "order/getByID",
                this.$store.getters["order/getByID"].data.id
            );
            if (res.status == 200) {
                this.dialog = false;
                this.$notify({
                    group: "main",
                    type: "success",
                    text: "เปลี่ยนสถานะ : ไม่ชำระมัดจำ"
                });
            } else {
                this.$notify({
                    group: "main",
                    type: "error",
                    text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้งภายหลัง"
                });
            }
            this.overlay = false;
        },
        emitAlert(alert) {
            this.form.alertSMS = alert.sms;
        }
    }
};
</script>

<style></style>
