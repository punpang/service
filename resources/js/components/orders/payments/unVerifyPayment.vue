<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn color="warning" v-on="on" @click="start">
                    <v-icon left>cancel</v-icon>
                    ไม่ผ่าน
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ไม่ผ่านการตรวจสอบ
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-alert type="warning"
                        >การแจ้งชำระนี้ ไม่ผ่านการตรวจสอบ</v-alert
                    >
                    <v-form ref="form" lazy-validation>
                        <v-select
                            outlined
                            label="เหตุผล"
                            v-model="slip_un_verify_reasoning_id"
                            :rules="[v => !!v]"
                            hide-details
                            :items="
                                this.$store.getters['payment/unVerifyReasoning']
                            "
                            item-text="reasoning"
                            item-value="id"
                            class="mb-4"
                        ></v-select>
                    </v-form>

                    <v-btn color="warning" @click="clickUnVerify">
                        <v-icon left>close</v-icon>
                        ไม่ผ่าน</v-btn
                    >
                    <v-btn color="error" @click="dialog = false">
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
import overlay from "@/js/layouts/overlay";

export default {
    props: ["form"],
    components: {
        overlay
    },
    data() {
        return {
            dialog: false,
            slip_un_verify_reasoning_id: "",
            overlay: false
        };
    },
    methods: {
        async clickUnVerify() {
            this.overlay = true;
            if (this.$refs.form.validate()) {
                let data = {
                    slip_id: this.form.slip_id,
                    slip_un_verify_reasoning_id: this
                        .slip_un_verify_reasoning_id
                };

                let response = await this.$store.dispatch(
                    "payment/unVerifySlip",
                    data
                );

                await this.$store.dispatch(
                    "order/getByID",
                    this.$store.getters["order/getByID"].data.id
                );

                if (response.status === 200) {
                    this.$emit("emitExit");
                    this.dialog = false;
                    this.$toast.success('ทำรายการสำเร็จ')
                } else {
                    this.$toast.error('เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้งภายหลังค่ะ')
                }
            } else {
                this.$toast.warning('กรุณากรอกข้อมูลให้ครบถ้วน')
            }
            this.overlay = false;
        },
        async start() {
            await this.$store.dispatch("payment/unVerifyReasoning");
        },
        mounted() {
            this.start();
        }
    }
};
</script>

<style></style>
