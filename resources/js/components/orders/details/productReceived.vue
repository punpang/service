<template>
    <div>
        <v-dialog v-model="dialog" persistent width="300">
            <template v-slot:activator="{ on }">
                <v-list-item
                    v-on="on"
                    :class="
                        sum.balance == 0
                            ? 'green accent-4'
                            : 'blue-grey lighten-1'
                    "
                    :disabled="sum.balance > 0"
                >
                    <v-list-item-icon>
                        <v-icon>done</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="py-1"
                            >รับสินค้า
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title class="pb-0"
                    >รับสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="clickExit">close</v-icon>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <formAlertSMS
                        :alertSMS="alertSMS"
                        @emitAlert="emitAlert"
                        class="mb-3"
                    ></formAlertSMS>
                    <v-btn color="success" @click="clickSubmit">
                        <v-icon left>done</v-icon>
                        รับสินค้า</v-btn
                    >
                    <v-btn color="error" @click="clickExit">
                        <v-icon left>exit_to_app</v-icon>
                        ออก</v-btn
                    >
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import formAlertSMS from "@/js/components/others/formAlertSMS";

export default {
    props: ["sum"],
    components: {
        formAlertSMS
    },
    data() {
        return {
            dialog: false,
            alertSMS: true
        };
    },
    methods: {
        emitAlert(data) {
            this.alertSMS = data.sms;
        },
        async clickSubmit() {
            let loader = this.$loading.show();
            const data = {
                order_id: this.$store.getters["order/getByID"].data.id,
                alertSMS: this.alertSMS
            };

            const res = await this.$store.dispatch(
                "order/productReceived",
                data
            );

            this.$store.dispatch("order/getByID", data.order_id);

            if (res.status == 200) {
                if (res.data.success) {
                    this.$toast.success(res.data.message);
                } else {
                    this.$toast.warning(res.data.message);
                }
            } else {
                this.$toast.warning("เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง");
            }
            this.clickExit();
            loader.hide();
        },
        clickExit() {
            this.dialog = false;
            this.alertSMS = true;
        }
    }
};
</script>
