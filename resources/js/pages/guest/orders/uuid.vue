<template>
    <div>
        <alertPaymentUUID></alertPaymentUUID>
        <!-- <div v-if="order.status != 9">
            <v-alert
                text
                :type="order.sumAll.sumDeposited == 0 ? 'warning' : 'success'"
                border="left"
                class="mb-2"
            >
                <strong v-if="order.sumAll.sumDeposited == 0"
                    >โปรดชำระเงินก่อน {{ order.payment_deadline_th }} น.</strong
                >
                <strong v-else
                    >ขอบคุณที่ชำระเงินเพื่อยืนยันการสั่งซื้อค่ะ</strong
                >
                <p
                    class="mb-0"
                    v-show="
                        !order.status_payment_deadline &&
                        order.sumAll.sumDeposited == 0
                    "
                >
                    เนื่องจากเกินกำหนดชำระเงิน
                    หากท่านยังต้องการสั่งซื้อรายการนี้
                    โปรดติดต่อทางร้านเพื่อขยายเวลาชำระเงินได้ที่
                    <a href="https://m.me/punpangpranburi">FACEBOOK</a> หรือ
                    โทร.
                    <a href="tel:091-885-3402">091-885-3402</a>
                </p>
                <v-spacer></v-spacer>
                <formPayment
                    class="mt-1"
                    v-if="
                        (order.status_payment_deadline &&
                            order.sumAll.sumDeposited == 0) ||
                        (order.sumAll.sumDeposited > 0 &&
                            order.sumAll.sumBalance > 0)
                    "
                ></formPayment>
            </v-alert>

            <v-sheet class="mx-auto pa-2 mb-2" outlined>
                <v-slide-group show-arrows>
                    <v-slide-item>
                        <cardFormNoticeOfPaymentByCustomer
                            v-if="order.ntpfcs_for_customer"
                            class="mx-1"
                        ></cardFormNoticeOfPaymentByCustomer>
                    </v-slide-item>
                </v-slide-group>
            </v-sheet>
        </div> -->

        <alertRatingUUID></alertRatingUUID>
        <!-- <v-container class="mb-2">
      <v-row justify="space-around">
        <cardFormNoticeOfPaymentByCustomer
          class="mr-1"
        ></cardFormNoticeOfPaymentByCustomer>
      </v-row>
    </v-container> -->

        <!-- <v-alert
      v-if="ntpfcsLength(order.ntpfcs_for_customer, 'create') > 0"
      type="cyan"
      text
      dense
      border="left"
      class="mb-2"
    >
      <v-container>
        <v-row>
          <cardFormNoticeOfPaymentByCustomer
            class="mr-1"
          ></cardFormNoticeOfPaymentByCustomer>

          สถานะการโอนชำระเงิน
        </v-row>
      </v-container>
    </v-alert> -->

        <!-- <v-card class="mb-2">
      <v-card-title class="text-h5 strong white--text warning">
        สรุปรายการสั่งซื้อ
      </v-card-title>
    </v-card> -->

        <formConditionPayment
            :propDialog="!order.customer.status_consent_condition"
        ></formConditionPayment>
        <cardDataOrderDetail></cardDataOrderDetail>
        <cardDataCustomer></cardDataCustomer>
        <cardDataGoodsDetail></cardDataGoodsDetail>

        <cardDeliveryShow v-if="order.status < 8"></cardDeliveryShow>

        <cardPaymentSummary></cardPaymentSummary>

        <!-- <v-bottom-navigation app class="yellow darken-4">
      <uploadImagesForOrder
        class="mt-2"
        :propImages="order.image_from_customers"
        @emitStart="emitStart"
      ></uploadImagesForOrder>
    </v-bottom-navigation> -->
    </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});

// import uploadImagesForOrder from "@/js/components/guest/uploadImagesForOrder";
import cardPaymentSummary from "@/js/components/order/cardPaymentSummary";
import cardDataCustomer from "@/js/components/order/cardDataCustomer";
import cardDataOrderDetail from "@/js/components/order/cardDataOrderDetail";
import cardDataGoodsDetail from "@/js/components/order/cardDataGoodsDetail";
import formConditionPayment from "@/js/components/guest/formConditionPayment";
import cardDeliveryShow from "@/js/components/order/delivery/show/cardDeliveryShow";
import alertRatingUUID from "@/js/components/guest/alertRatingUUID";
import alertPaymentUUID from "@/js/components/guest/alertPaymentUUID";

import { mapGetters } from "vuex";
export default {
    components: {
        // uploadImagesForOrder,
        cardPaymentSummary,
        cardDataCustomer,
        cardDataOrderDetail,
        cardDataGoodsDetail,
        formConditionPayment,
        cardDeliveryShow,
        alertRatingUUID,
        alertPaymentUUID,
    },
    data() {
        return {};
    },
    methods: {
        async start() {
            let loader = this.$loading.show();
            const result = await this.$store.dispatch(
                "orderIndex/getOrderByUUID",
                {
                    uuid: this.$route.params.uuid,
                }
            );
            if (result.status != 200) {
                this.$swal({
                    title: "เกิดข้อผิดพลาด",
                    icon: "error",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            }
            loader.hide();
        },
        // status_payment_deadline() {
        //     const now = new Date();
        //     const nowParse = Date.parse(now.toLocaleString());
        //     const deadlineParse = Date.parse(this.order.payment_deadline);
        //     return deadlineParse > nowParse;
        // },
        // status_payment_deadline(payment_deadline) {
        //     const now = new Date();
        //     console.log(now.getTime());
        //     let deadlineParse = new Date(payment_deadline);
        //     if (isNaN(deadlineParse.getTime())) {
        //         deadlineParse = now;
        //     }
        //     console.log(deadlineParse.getTime());
        //     return deadlineParse.getTime() > now.getTime();
        //     // if (deadlineParse.valueOf() > now.valueOf()) {
        //     //     return true;
        //     // }
        //     // return false;
        // },
        ntpfcsLength(v) {
            const ntpfcs = v.filter((v) => {
                return v.status;
            });
            return ntpfcs.length;
        },
        emitStart() {
            this.start();
        },

        async ksherPaySuccess() {
            if (this.$route.query.mch_order_no) {
                let loader = this.$loading.show();
                const result = await this.$store.dispatch(
                    "orderKsher/checkStatusPaid",
                    {
                        mch_order_no: this.$route.query.mch_order_no,
                    }
                );
                if (result.status == 200) {
                    this.$swal({
                        title: result.data.message.title,
                        text: result.data.message.text,
                        icon: result.data.message.icon,
                        allowOutsideClick: false,
                        confirmButtonText: "เรียบร้อย",
                    }).then((response) => {
                        if (response.isConfirmed) {
                            this.start();
                        }
                    });
                } else {
                    this.$swal({
                        title: "เกิดข้อผิดพลาดบางประการ",
                        text: "โปรดลองอีกครั้งภายหลัง",
                        icon: "error",
                        allowOutsideClick: false,
                        confirmButtonText: "รับทราบ",
                    }).then((response) => {
                        if (response.isConfirmed) {
                            this.start();
                        }
                    });
                }
                loader.hide();
            }
        },
    },
    async mounted() {
        await this.start();
        await this.ksherPaySuccess();
        // await axios.get(`/api/${this.$route.params.id}/test`);
    },

    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
