<template>
    <div>
        <v-dialog persistent width="800" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn elevation="0" v-on="on" @click="clickStart">
                    <v-icon left>list</v-icon>
                    <strong>รายละเอียด</strong>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ตรวจสอบสลิปชำระเงิน
                    <v-spacer></v-spacer>
                    <v-btn
                        icon
                        fab
                        x-small
                        class="white"
                        @click="dialog = false"
                    >
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12" sm="8" md="8">
                            <v-img
                                :src="
                                    'https://drive.google.com/thumbnail?id=' +
                                    propNtpfc.src_name +
                                    '&sz=w1000-h1000'
                                "
                            ></v-img>
                        </v-col>
                        <v-col cols="12" sm="4" md="4">
                            <v-text-field
                                label="ยอดคงเหลือ"
                                hide-details
                                readonly
                                outlined
                                suffix="บาท"
                                required
                                class="mb-3"
                                v-model="sumAll.sumBalance"
                            ></v-text-field>
                            <v-text-field
                                label="จำนวนเงิน"
                                hide-details
                                type="number"
                                pattern="/d*"
                                outlined
                                suffix="บาท"
                                required
                                class="mb-3"
                                v-model="amount"
                            ></v-text-field>
                            <v-text-field
                                label="ref"
                                hide-details
                                outlined
                                v-model="ref"
                                :disabled="status !== 'create'"
                            ></v-text-field>

                            <v-divider></v-divider>
                            <v-btn
                                @click="clickCheckSlip"
                                class="success"
                                x-large
                                v-if="status === 'create'"
                                :disabled="!ref || !amount"
                            >
                                <v-icon left>check_circle</v-icon>
                                <strong>ตรวจสอบ</strong>
                            </v-btn>
                            <v-btn
                                @click="clickUpdateSlip"
                                class="success"
                                x-large
                                v-if="status === 'success'"
                                :disabled="!ref || !amount"
                            >
                                <v-icon left>check_circle</v-icon>
                                <strong>ปรับปรุงรายการ</strong>
                            </v-btn>

                            <v-btn
                                @click="clickAppealSlip"
                                class="success"
                                x-large
                                v-if="status === 'cancel'"
                            >
                                <v-icon left>check_circle</v-icon>
                                <strong>อุทธรณ์</strong>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-divider class="ma-0"></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        @click="clickCancelSlip()"
                        color="error"
                        outlined
                        x-large
                        v-if="status == 'create'"
                    >
                        <v-icon left>delete</v-icon>
                        <strong>ยกเลิกรายการนี้</strong>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["propNtpfc"],
    data() {
        return {
            dialog: false,
            ref: "",
            amount: 0,
            status: "",
            ntpfc: {},
            sumAll: {},
        };
    },
    methods: {
        async processingCancelSlip() {
            let loader = this.$loading.show();
            const payload = this.propNtpfc;
            await this.$store
                .dispatch(`orderNoticeOfPaymentFromCustomer/setCancel`, payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        title: response.title,
                        icon: response.icon,
                        allowOutsideClick: true,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                    });
                });
            this.$emit("emitStart");
            this.dialog = false;
            loader.hide();
        },
        clickCancelSlip() {
            this.$swal({
                title: "โปรดอ่าน",
                icon: "warning",
                text: "ต้องการยกเลิกรายการนี้ใช่หรือไม่",
                allowOutsideClick: false,
                denyButtonText: "ไม่ใช่ ,ออก",
                confirmButtonText: "ใช่ ,ยกเลิก",
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.processingCancelSlip();
                } else if (result.isDenied) {
                    return;
                }
            });
        },
        clickCheckSlip() {
            if (this.amount > this.sumAll.sumBalance) {
                this.$swal({
                    title: "โปรดอ่าน",
                    icon: "warning",
                    text: "ยอดชำระเงิน มากกว่า ยอดคงเหลือ",
                    allowOutsideClick: false,
                    denyButtonText: "ไม่ถูกต้อง",
                    confirmButtonText: "ถูกต้อง",
                    showDenyButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.checkSlip();
                    } else if (result.isDenied) {
                        return;
                    }
                });
            } else {
                this.checkSlip();
            }
        },
        async checkSlip() {
            let loader = this.$loading.show();
            const payload = {
                ntpfc: this.ntpfc,
                ref: this.ref,
                amount: this.amount,
            };

            const res = await this.$store.dispatch(
                `orderNoticeOfPaymentFromCustomer/postCheckSlip`,
                payload
            );

            if (res.status === 200) {
                this.$swal({
                    title: res.data.title,
                    text: res.data.text,
                    icon: res.data.status,
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$emit("emitStart");
                        this.dialog = false;
                    }
                });
            } else {
                this.$swal({
                    title: "Error 500",
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            }

            loader.hide();
        },
        async clickAppealSlip() {
            let loader = this.$loading.show();
            const payload = {
                ntpfc: this.ntpfc,
            };

            const res = await this.$store.dispatch(
                `orderNoticeOfPaymentFromCustomer/postAppealSlip`,
                payload
            );

            if (res.status === 200) {
                this.$swal({
                    title: res.data.title,
                    text: res.data.text,
                    icon: res.data.status,
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$emit("emitStart");
                        this.dialog = false;
                    }
                });
            } else {
                this.$swal({
                    title: "Error 500",
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            }

            loader.hide();
        },

        async clickUpdateSlip() {
            if (this.amount > this.sumAll.sumBalance + this.ntpfc.amount) {
                this.$toast.warning("ยอดชำระเงิน มากกว่า ยอดคงเหลือ");
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                ntpfc: this.ntpfc,
                amount: this.amount,
            };

            const res = await this.$store.dispatch(
                `orderNoticeOfPaymentFromCustomer/postUpdateSlip`,
                payload
            );

            if (res.status === 200) {
                this.$swal({
                    title: res.data.title,
                    text: res.data.text,
                    icon: res.data.status,
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$emit("emitStart");
                        this.dialog = false;
                    }
                });
            } else {
                this.$swal({
                    title: "Error 500",
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            }

            loader.hide();
        },
        async clickStart() {
            const payload = {
                ntpfc: this.propNtpfc,
            };
            const res = await this.$store.dispatch(
                `orderNoticeOfPaymentFromCustomer/getCheckSlip`,
                payload
            );

            //   this.ref = "012029151143828695";
            const notice = res.data.notice;
            this.ref = notice.ref;
            this.ntpfc = notice;
            this.amount = notice.amount;
            this.status = notice.status;
            this.sumAll = res.data.sumAll;
        },
    },
};
</script>
