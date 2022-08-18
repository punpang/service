<template>
    <div>
        <v-dialog persistent scrollable width="500" v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    large
                    class="success"
                    :disabled="
                        propChannelID === 6 ||
                        propDeposit <= 0 ||
                        sumAll.sumTASC / 2 > propDeposit
                    "
                    @click="clickSubmitPayment"
                >
                    <v-icon left>payments</v-icon>
                    ทำรายการต่อไป</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    กำลังชำระเงิน {{ propChannelID }}
                    <v-spacer></v-spacer>
                    <v-btn icon fab small @click="exit">
                        <v-icon color="error" @click="exit">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-card outlined class="mb-2 mt-2">
                        <v-card-text>
                            <v-simple-table>
                                <tr>
                                    <td>
                                        <strong>จำนวนเงินที่ชำระ</strong>
                                    </td>
                                    <td class="text-right">
                                        <strong>
                                            {{ propDeposit | formatNumber }} บาท
                                        </strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>
                                            {{ paymentChannel.remark }}</strong
                                        >
                                    </td>
                                    <td class="text-right">
                                        <strong>
                                            {{ fee_value | formatNumber }} บาท
                                        </strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>รวมยอดที่ชำระ</strong>
                                    </td>
                                    <td class="text-right">
                                        <strong>
                                            {{ amount | formatNumber }} บาท
                                        </strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>ช่องทางชำระเงิน</strong>
                                    </td>
                                    <td class="text-right">
                                        <strong>
                                            {{ paymentChannel.text }}</strong
                                        >
                                    </td>
                                </tr>
                            </v-simple-table>
                        </v-card-text>
                    </v-card>
                    <v-card outlined>
                        <v-card-text
                            v-if="propChannelID == 1 || propChannelID == 7"
                            class="align-center"
                        >
                            <v-alert type="info">ไม่ต้องแจ้งชำระเงิน</v-alert>
                            <v-flex class="text-center mt-2 mb-5">
                                <!-- <strong>โปรดใช้พร้อมเพย์เพื่อชำระเงิน</strong> -->
                                <v-img
                                    class="mx-auto my-2"
                                    max-width="350"
                                    src="https://drive.google.com/thumbnail?id=14rEPFrM2t0T7I5UxS-UCwWIUT5EAICNI&sz=w500-h500"
                                >
                                </v-img>
                                <v-img
                                    class="mx-auto my-2"
                                    max-width="200"
                                    :src="ksherPay.imgdat"
                                ></v-img>
                                <br />
                                <strong class="h5"
                                    >บัญชี: เคเชอร์เพย์ (KSHER PAY)</strong
                                >
                                <br />
                                <strong class="h5"
                                    >จำนวนเงิน:
                                    {{ amount | formatNumber }} บาท</strong
                                >
                                <!-- <strong
                                    >โปรดทำการชำระเงินเพียงครั้งเดียว</strong
                                > -->
                                <!-- :src="qrcodeTest" -->
                            </v-flex>
                            <v-alert type="error" dense v-if="timeUp != 0"
                                >QR CODE มีอายุ 10 นาที จะหมดอายุ
                                {{ timeUp }} น.</v-alert
                            >
                            <v-divider></v-divider>
                            <p class="mb-1">
                                1. แคปหน้าจอหน้านี้ โดยให้เห็น QR CODE เต็มรูป
                            </p>
                            <p class="mb-1">
                                2. เปิด Mobile Banking App (แอพธนาคาร)
                                บนมือถือของคุณ
                            </p>
                            <p class="mb-1">
                                3. เลือกไปที่ 'สแกน' หรือ 'คิวอาร์โค้ด' กด
                                'รูปภาพ'
                            </p>
                            <p class="mb-1">
                                4. เลือกรูปภาพที่คุณแคปไว้และทำการชำระเงิน
                            </p>
                            <p class="mb-1">
                                5. เมื่อชำระเงินเสร็จ กลับมายังหน้าชำระเงิน
                                และรอสักครู่ ระบบจะนำท่านไปยังหน้าชำระเงินสำเร็จ
                            </p>
                            <howToUsePropmptPay></howToUsePropmptPay>
                        </v-card-text>
                        <v-card-text
                            v-else-if="propChannelID >= 2 && propChannelID <= 4"
                        >
                            <v-alert type="warning" text
                                >โปรดตรวจสอบยอดชำระก่อน
                                <strong>"ชำระเงิน"</strong></v-alert
                            >
                            <v-alert type="info" text
                                >ไม่ต้องแจ้งชำระเงิน</v-alert
                            >

                            <strong>ทางร้านใช้ระบบชำระเงินของ Ksher Pay</strong>
                            <v-spacer></v-spacer>

                            <v-btn
                                class="success"
                                x-large
                                block
                                @click="ksherPayOrderCreate"
                            >
                                <v-icon left>payments</v-icon>
                                ชำระเงิน
                            </v-btn>
                        </v-card-text>
                        <v-card-text v-else-if="propChannelID == 5">
                            <uploadImage
                                :propUploadImange="uploadImange"
                                @emitImageId="emitImageId"
                            ></uploadImage>
                            <v-alert
                                color="warning"
                                class="mb-0 mt-2"
                                dark
                                dense
                            >
                                <strong class="mb-0 text-caption"
                                    >จำเป็นต้องแนบสลิป หลังจากชำระเงิน</strong
                                >
                            </v-alert>

                            <cardFormDetailBank></cardFormDetailBank>
                        </v-card-text>
                    </v-card>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import howToUsePropmptPay from "@/js/components/guest/howToUsePropmptPay";
import cardFormDetailBank from "@/js/components/guest/cardFormDetailBank";
import uploadImage from "@/js/components/google/drive/uploadImage";
import { mapGetters } from "vuex";

var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    props: ["propDeposit", "propChannelID", "propTotal"],
    components: { howToUsePropmptPay, cardFormDetailBank, uploadImage },
    data() {
        return {
            dialog: false,
            paymentChannel: {},
            fee_value: 0,
            amount: 0,
            uploadImange: { imagePreview: "", file: null },
            // countDown: {
            //     m: 0,
            //     h: 0,
            //     total: 0,
            // },
            timeUp: "",
        };
    },
    methods: {
        setTimeUp() {
            const time = new Date();
            const newTime = time.setMinutes(time.getMinutes() + 10);
            const timeUp = new Date(newTime);
            this.timeUp = timeUp.toLocaleString();
            // .setMinutes(time.getMinutes() + 10)
            // .toLocaleString();
        },
        // setTimeCountDown() {
        //     if (this.countDown.total > 0) {
        //         setTimeout(() => {
        //             this.countDown.m = parseInt(this.countDown.total / 60);
        //             this.countDown.h = Math.ceil(
        //                 (this.countDown.total / 60 - this.countDown.m) * 60
        //             );
        //             this.countDown.total -= 1;
        //             this.setTimeCountDown();
        //         }, 1000);
        //     }
        // },
        async emitImageId(response) {
            if (response.status === 200) {
                const data = response.data;
                const payload = {
                    uuid: this.$route.params.uuid,
                    src_name: data.image.src_name,
                    amount: this.amount,
                };

                let loader = this.$loading.show();
                const res = await this.$store.dispatch(
                    `orderNoticeOfPaymentFromCustomer/createByUuid`,
                    payload
                );

                loader.hide();
                this.$swal({
                    title: res.data.message,
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                }).then((response) => {
                    if (response.isConfirmed) {
                        let loader = this.$loading.show();
                        location.reload();
                    }
                });
            }
        },
        exit() {
            this.dialog = false;
        },
        async clickSubmitPayment() {
            const paymentChannels = this.useKsherChannelPayment;
            const channel = paymentChannels.filter(
                (paymentChannels) => paymentChannels.id === this.propChannelID
            );

            this.paymentChannel = channel[0];

            if (this.propDeposit < this.paymentChannel.minimum) {
                this.$swal({
                    icon: "warning",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    text: `ยอดชำระขั้นต่ำ ${this.paymentChannel.minimum} บาท`,
                });
                return;
            }

            if (this.propChannelID === "") {
                this.$swal({
                    icon: "warning",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    text: "โปรดเลือกช่องทางชำระเงิน",
                });
                return;
            }

            let deposit = 0;
            let fee_value = 0;
            if (channel[0].fee_type === "percent") {
                fee_value = (this.propDeposit * channel[0].fee_value) / 100;
            } else if (channel[0].fee_type === "bath") {
                fee_value = channel[0].fee_value;
            }
            deposit = this.propDeposit + fee_value;
            this.fee_value = fee_value;
            this.amount = deposit;
            if (this.paymentChannel.payment_code === "promptpayQR") {
                await this.ksherPayOrderCreate();
            }
        },
        async ksherPayOrderCreate() {
            if (this.paymentChannel.payment_code === "transferByCustomer") {
                return;
            }
            const date = new Date();
            const payload = {
                mch_order_no: `${this.order.id}-${date.getTime()}`,
                total_fee: this.amount,
                fee_type: "THB",
                uuid: this.$route.params.uuid,
                channel: this.paymentChannel,
                // notify_url: "https://webhook.site/56cf83c4-6e12-4852-b83b-4fa55248b4f8",
                amount: this.propDeposit,
            };

            let loader = this.$loading.show();
            const res = await this.$store.dispatch(
                "orderKsher/createKsherPay",
                payload
            );

            this.setTimeUp();

            if (res.result === "FAIL") {
                this.$swal({
                    title: "โปรดอ่าน",
                    icon: "error",
                    text: "ระบบชำระเงินอัตโนมัติขัดข้องชั่วคราว โปรดชำระเงินด้วยวิธีโอนชำระด้วยตัวเองแทน",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.dialog = false;
                    }
                });
            }

            if (
                this.paymentChannel.payment_code === "eWallet" ||
                this.paymentChannel.payment_code === "mobileBanking" ||
                this.paymentChannel.payment_code === "debitCreditCard"
            ) {
                window.location.replace(res.pay_content);
            }
            loader.hide();
        },
    },
    mounted() {
        window.Echo.channel("KsherPayEventOn").listen(
            ".KsherPayEventAs",
            (e) => {
                const data = e.data;
                if (
                    data.result === "success" &&
                    parseInt(data.order_id) === parseInt(this.order.id)
                ) {
                    this.$swal({
                        title: data.message,
                        text: "ขอบคุณที่ชำระเงินค่ะ",
                        icon: "success",
                        allowOutsideClick: false,
                        confirmButtonText: "รับทราบ",
                    }).then((response) => {
                        if (response.isConfirmed) {
                            this.$loading.show();
                            location.reload();
                        }
                    });
                } else if (
                    data.result === "fail" &&
                    parseInt(data.order_id) === parseInt(this.order.id)
                ) {
                    this.$swal({
                        title: data.message,
                        text: "โปรดลองอีกครั้ง หรือ ติดต่อทางร้าน",
                        icon: "success",
                        allowOutsideClick: false,
                        confirmButtonText: "รับทราบ",
                    });
                }
            }
        );
        //
        // window.Echo.channel("KitchenQueueOrderFetchOn").listen(
        //   ".KitchenQueueOrderFetchAs",
        //   (e) => {
        //     if (this.status === true && !this.self.id) {
        //       this.playSound();
        //       this.start();
        //     }
        //   }
        // );
    },
    computed: {
        ...mapGetters({
            useKsherChannelPayment: "orderKsher/useKsherChannelPayment",
            order: "orderIndex/order",
            sumAll: "orderIndex/sumAll",

            ksherPay: "orderKsher/ksherPay",
        }),
    },
};
// qrcodeTest:
//         "data:image/png;base64,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",
</script>
