<template>
    <div>
        <v-dialog
            persistent
            width="500"
            v-model="dialog"
            transition="dialog-top-transition"
            scrollable
            fullscreen
        >
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" @click="start()" class="teal">
                    <v-icon left>receipt</v-icon>ชำระเงิน
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h5 white--text warning">
                    <v-icon left color="white">receipt</v-icon>ชำระเงิน
                    <v-spacer></v-spacer>
                    <v-btn fab small icon class="white" @click="exit">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-card outlined class="mb-2 mt-2">
                        <v-card-text>
                            <strong class="black--text"
                                >ยอดที่ต้องการชำระ</strong
                            >
                            <v-text-field
                                @click="clickDepositTxt"
                                hide-details
                                label="จำนวนเงิน"
                                outlined
                                suffix="บาท"
                                class="mb-2 mt-3 text-right"
                                type="number"
                                pattern="\d*"
                                v-model="deposit"
                                readonly
                            ></v-text-field>
                            <v-chip-group
                                active-class="primary--text"
                                v-model="option"
                                column
                                mandatory
                            >
                                <v-chip
                                    @change="
                                        changeAmountDeposit(optionAmount.id)
                                    "
                                    v-for="optionAmount in optionAmounts"
                                    :key="optionAmount.id"
                                    :disabled="order.status_full_payment == 1"
                                >
                                    {{ optionAmount.text }}
                                </v-chip>
                            </v-chip-group>
                            <strong
                                class="error--text"
                                v-if="order.status_full_payment == 1"
                                >ไม่สามารถเปลี่ยนแปลงยอดที่ต้องการชำระเงินได้
                                เนื่องจากท่านต้องชำระเงินเต็มจำนวน</strong
                            >
                        </v-card-text>
                    </v-card>

                    <v-card outlined class="mb-2">
                        <v-card-text>
                            <strong class="black--text">ช่องทางชำระเงิน</strong>
                            <v-item-group mandatory v-model="channel">
                                <v-container>
                                    <v-row>
                                        <v-col
                                            v-for="paymentChannel in useKsherChannelPayment"
                                            :key="paymentChannel.id"
                                            class="p-1"
                                            cols="12"
                                            md="4"
                                            sm="6"
                                            lg="3"
                                            @click="
                                                clickChannel(paymentChannel)
                                            "
                                        >
                                            <v-item v-slot="{ active, toggle }">
                                                <v-card
                                                    :color="
                                                        active ? 'primary' : ''
                                                    "
                                                    class="d-flex align-center px-2"
                                                    height="150"
                                                    @click="toggle"
                                                    :disabled="
                                                        !paymentChannel.status_use ||
                                                        deposit <
                                                            paymentChannel.minimum ||
                                                        sumAll.sumTASC >
                                                            paymentChannel.maximum ||
                                                        paymentChannel.ksher_day_off !=
                                                            null
                                                    "
                                                >
                                                    <v-scroll-y-transition>
                                                        <div
                                                            v-if="active"
                                                            class="text-h2 flex-grow-1 text-center"
                                                        ></div>
                                                    </v-scroll-y-transition>

                                                    <v-card-text
                                                        class="text-center p-0"
                                                        :class="
                                                            active
                                                                ? 'white--text'
                                                                : ''
                                                        "
                                                    >
                                                        <h6 class="mb-0">
                                                            <strong>{{
                                                                paymentChannel.text
                                                            }}</strong>
                                                        </h6>
                                                        <v-img
                                                            class="my-1"
                                                            :src="
                                                                'https://drive.google.com/thumbnail?id=' +
                                                                paymentChannel.image2 +
                                                                '&sz=w600-h600'
                                                            "
                                                        ></v-img>
                                                        <h6 class="mb-0">
                                                            <strong
                                                                v-if="
                                                                    paymentChannel.status_use &&
                                                                    deposit >=
                                                                        paymentChannel.minimum
                                                                "
                                                                >{{
                                                                    paymentChannel.remark
                                                                }}</strong
                                                            >
                                                            <strong
                                                                v-else-if="
                                                                    !paymentChannel.status_use
                                                                "
                                                                class="red--text"
                                                                >ปิดปรับปรุงชั่วคราว</strong
                                                            >
                                                            <strong
                                                                v-else-if="
                                                                    paymentChannel.status_use &&
                                                                    deposit <
                                                                        paymentChannel.minimum
                                                                "
                                                                :class="
                                                                    active
                                                                        ? 'white--text'
                                                                        : 'red--text'
                                                                "
                                                                >ยอดชำระขั้นต่ำ
                                                                {{
                                                                    paymentChannel.minimum
                                                                }}
                                                                บาท</strong
                                                            >
                                                        </h6>
                                                    </v-card-text>
                                                </v-card>
                                            </v-item>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-item-group>
                        </v-card-text>
                    </v-card>
                    <v-card outlined class="mb-2 mt-2">
                        <cardFormPaymentSummary></cardFormPaymentSummary>
                    </v-card>
                </v-card-text>
                <v-card-actions class="grey lighten-2">
                    <v-btn large class="mr-2 error" @click="exit">
                        <v-icon left>exit_to_app</v-icon>
                        ออกจากหน้านี้</v-btn
                    >
                    <v-spacer></v-spacer>

                    <paymentToCheckOut
                        :propDeposit="deposit"
                        :propChannelID="channel_id"
                        :propTotal="order.total"
                    ></paymentToCheckOut>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import formConditionPayment from "@/js/components/guest/formConditionPayment";
import paymentToCheckOut from "@/js/components/guest/paymentToCheckOut";
import cardFormPaymentSummary from "@/js/components/order/cardFormPaymentSummary";

import { mapGetters } from "vuex";

var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
export default {
    props: ["propDataOrder"],
    components: {
        formConditionPayment,
        paymentToCheckOut,
        cardFormPaymentSummary,
    },
    data() {
        return {
            dialog: false,
            option: "",
            // total: 101,
            deposit: 0,
            channel: 0,
            channel_id: 1,
            textClickAlertAmount: "",
            deposits: {
                haft: false,
                full: false,
            },
            amountOptions: [
                { id: 2, text: "ชำระเต็มจำนวน", group: 1 },
                { id: 1, text: "ชำระ 50 %", group: 1 },
                { id: 3, text: "ชำระยอดคงเหลือ", group: 2 },
            ],
            optionAmounts: {},
            // paymentChannels: [
            //   {
            //     id: 1,
            //     payment_code: "promptpayQR",
            //     text: "QR CODE พร้อมเพย์",
            //     remark: "ไม่มีค่าธรรมเนียม",
            //     color: "info",
            //     image: "1AU5EBhr1zLrCD3bbU_CoCvI1YhiLtREd",
            //     image2: "1jpGiesT_GVoZoK_zc7pvg3IHpfqkb9oQ",
            //     fee_value: 0,
            //     fee_type: "bath",
            //     fee_type_th: "บาท",
            //     status_use: 1,
            //   },
            //   {
            //     id: 2,
            //     payment_code: "eWallet",
            //     text: "E-WALLET",
            //     remark: "ค่าธรรมเนียม 3%",
            //     image: "18azZhssTmSzxpVH-9yRoeXQTlZqQL12w",
            //     image2: "1dkP7rTQkUiowO_2mhCKM_70_Qf_B7ElN",
            //     fee_value: 3,
            //     fee_type: "percent",
            //     fee_type_th: "เปอร์เซ็นต์",
            //     status_use: 1,
            //   },
            //   {
            //     id: 3,
            //     payment_code: "mobileBanking",
            //     text: "MOBILE BANKING",
            //     remark: "ค่าธรรมเนียม 15 บาท",
            //     color: "error",
            //     image: "14KKzrkyTqXFHWHzhPMWyrozAn13EHi48",
            //     image2: "1hdrVzp2Hsxy0O--5OEM_QKsIyBvrhOI-",
            //     fee_value: 15,
            //     fee_type: "bath",
            //     fee_type_th: "บาท",
            //     status_use: 1,
            //   },
            //   {
            //     id: 4,
            //     payment_code: "debitCreditCard",
            //     text: "บัตรเดบิต/บัตรเครดิต",
            //     remark: "ค่าธรรมเนียม 3 %",
            //     color: "error",
            //     image: "",
            //     image2: "1IRBZVqtAKU0tTeERDwf0j0QL44KfD4de",
            //     fee_value: 3,
            //     fee_type: "percent",
            //     fee_type_th: "เปอร์เซนต์",
            //     status_use: 1,
            //   },
            //   {
            //     id: 5,
            //     payment_code: "transferByCustomer",
            //     text: "โอนชำระด้วยตัวเอง",
            //     remark: "ไม่มีค่าธรรมเนียม",
            //     color: "error",
            //     image: "",
            //     image2: "1zzP9yRA5-DvIx03SKHabOZvBOX_miTjU",
            //     fee_value: 0,
            //     fee_type: "bath",
            //     fee_type_th: "บาท",
            //     status_use: 1,
            //   },
            //   {
            //     id: 6,
            //     payment_code: "notPayment",
            //     text: "ไม่สะดวกชำระมัดจำ",
            //     remark: "โปรดติดต่อทางร้าน",
            //     color: "error",
            //     image: "",
            //     image2: "1b6aPVEkRSvigHbryeT3nC5B_rVDvFDV7",
            //     fee_value: 10,
            //     fee_type: "bath",
            //     fee_type_th: "บาท",
            //     status_use: 1,
            //   },
            // ],
        };
    },
    methods: {
        clickChannel(v) {
            this.channel_id = v.id;
            if (v.payment_code == "notPayment") {
                this.$swal({
                    title: "โปรดติดต่อทางร้าน",
                    icon: "info",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    html:
                        'สามารถติดต่อได้ที่ <a href="https://m.me/punpangpranburi">FACEBOOK</a> ' +
                        'หรือ <a href="https://lin.ee/cNMXD67">LINE</a> <br>' +
                        "เลือกช่องที่สะดวกได้เลยค่ะ",
                });

                return;
            }

            return;
        },
        changeChannel(v) {
            if (v == 4) {
                this.$swal({
                    title: "โปรดติดต่อทางร้าน",
                    icon: "info",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    html:
                        'สามารถติดต่อได้ที่ <a href="https://m.me/punpangpranburi">FACEBOOK</a> ' +
                        'หรือ <a href="https://lin.ee/cNMXD67">LINE</a> <br>' +
                        "เลือกช่องที่สะดวกได้เลยค่ะ",
                });
            }
        },
        // clickSubmitPayment() {
        //   if (!this.consentConditionPayment) {
        //     this.$swal({
        //       icon: "warning",
        //       allowOutsideClick: false,
        //       confirmButtonText: "รับทราบ",
        //       text: "โปรดอ่านและยินยอมเงื่อนไข",
        //     });

        //     return;
        //   }

        //   if (this.deposit < this.total / 2) {
        //     this.$swal({
        //       icon: "warning",
        //       allowOutsideClick: false,
        //       confirmButtonText: "รับทราบ",
        //       text: "ยอดจำนวนเงินไม่ถูกต้อง",
        //     });
        //     return;
        //   }

        //   if (this.channel_id == "") {
        //     this.$swal({
        //       icon: "warning",
        //       allowOutsideClick: false,
        //       confirmButtonText: "รับทราบ",
        //       text: "โปรดเลือกช่องทางชำระเงิน",
        //     });
        //     return;
        //   }

        //   const channel = this.paymentChannels[this.channel];
        //   let deposit = 0;
        //   if (channel.fee_type == "percent") {
        //     deposit = this.deposit + (this.deposit * channel.fee_value) / 100;
        //   } else if (channel.fee_type == "bath") {
        //     deposit = this.deposit + channel.fee_value;
        //   }
        // },

        clickDepositTxt() {
            this.$swal({
                title: "คำแนะนำ",
                icon: "info",
                text: `โปรดเลือกจากตัวเลือก ${this.textClickAlertAmount}`,
                allowOutsideClick: false,
                confirmButtonText: "รับทราบ",
                confirmButtonColor: "success",
            });
        },
        changeAmountDeposit(v) {
            switch (v) {
                case 1:
                    this.textClickAlertAmount = `"ชำระเต็มจำนวน" / "ชำระ 50 %"`;
                    this.deposit = parseInt(this.sumAll.sumTASC / 2);
                    break;
                case 2:
                    this.textClickAlertAmount = `"ชำระเต็มจำนวน" / "ชำระ 50 %"`;
                    this.deposit = this.sumAll.sumTASC;
                    break;
                case 3:
                    this.textClickAlertAmount = `"ชำระยอดคงเหลือ"`;
                    this.deposit = this.sumAll.sumBalance;
                    break;
            }
        },
        exit() {
            this.dialog = false;
        },
        CaseOptionAmounts() {
            const options = this.amountOptions;
            // let group = 0;
            // if (this.sumAll.sumDeposited == 0) {
            //     group = 1;
            // } else {
            //     group = 2;
            // }

            let group = this.sumAll.sumDeposited == 0 ? 1 : 2;

            let option = options.filter((options) => options.group == group);

            this.optionAmounts = option;

            this.changeAmountDeposit(option[0].id);
        },
        async start() {
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getOrderByUUID", {
                uuid: this.$route.params.uuid,
            });
            const payload = {
                order : this.order
            }
            await this.$store.dispatch("orderKsher/getUseKsherChannelPayment_v2", payload);
            await this.CaseOptionAmounts();

            if (this.sumAll.sumTASC > 500) {
                const filter = await this.useKsherChannelPayment.filter(
                    (e) => e.maximum > this.sumAll.sumTASC
                );
                await this.$store.commit(
                    "orderKsher/useKsherChannelPayment",
                    filter
                );
                await this.clickChannel(filter[0]);
            } else {
                this.clickChannel(this.useKsherChannelPayment[0]);
            }

            loader.hide();
        },
    },

    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            sumAll: "orderIndex/sumAll",
            useKsherChannelPayment: "orderKsher/useKsherChannelPayment",
        }),
    },
};
</script>
