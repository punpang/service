<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            width="500"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-title> ไม่ชำระมัดจำ </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ไม่ชำระมัดจำ
                    <v-spacer></v-spacer>
                    <v-btn fab icon x-small class="waring">
                        <v-icon color="white" @click="exit()">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pa-3">
                    <cardNoPayment :propOption="option"></cardNoPayment>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large class="error" @click="exit()">
                        <v-icon left>exit_to_app</v-icon> ออก
                    </v-btn>
                    <v-btn large class="success" @click="clickSave()">
                        <v-icon left>save</v-icon>

                        บันทึก</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardNoPayment from "@/js/components/order/manages/noPayment/card";
export default {
    components: { cardNoPayment },
    data() {
        return {
            dialog: false,
            option: {
                waiting_period: "10-30 นาที",
                status_id: "",
            },
        };
    },
    methods: {
        exit() {
            this.dialog = false;
        },
        emitExitCardPayment() {
            this.dialog = false;
        },
        async clickSave() {
            if (!this.option.waiting_period || !this.option.status_id) {
                this.$swal({
                    toast: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 3000,
                    title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                    icon: "warning",
                    position: "bottom",
                });
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                option: this.option,
                order_id: this.$route.params.id,
            };

            const result = await this.$store.dispatch(
                "orderIndex/customerNoPayment",
                payload
            );

            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });
            loader.hide();
            this.exit();
            this.$swal({
                toast: true,
                showConfirmButton: false,
                allowOutsideClick: false,
                timerProgressBar: true,
                timer: 3000,
                title: result.data.title,
                icon: result.data.icon,
                position: "bottom",
            });
            return;
        },
    },
};
</script>
