<template>
    <div>
        <v-alert
            text
            :type="order.sumAll.sumDeposited === 0 ? 'warning' : 'success'"
            border="left"
            class="mb-2"
        >
            <strong v-if="order.sumAll.sumDeposited === 0"
                >โปรดชำระเงินก่อน {{ order.payment_deadline_th }} น.</strong
            >
            <strong v-else>ขอบคุณที่ชำระเงินเพื่อยืนยันการสั่งซื้อค่ะ</strong>
            <p
                class="mb-0"
                v-show="
                    !status_payment_deadline() &&
                    order.sumAll.sumDeposited === 0
                "
            >
                เนื่องจากเกินกำหนดชำระเงิน หากท่านยังต้องการสั่งซื้อรายการนี้
                โปรดติดต่อทางร้านเพื่อขยายเวลาชำระเงินได้ที่
                <a href="https://m.me/punpangpranburi">FACEBOOK</a> หรือ โทร.
                <a href="tel:091-885-3402">091-885-3402</a>
            </p>
            <v-spacer></v-spacer>
            <formPayment
                class="mt-1"
                v-if="
                    (status_payment_deadline() &&
                        order.sumAll.sumDeposited === 0) ||
                    (order.sumAll.sumDeposited > 0 &&
                        order.sumAll.sumBalance > 0)
                "
            ></formPayment>
        </v-alert>

    <v-sheet class="mx-auto pa-2 mb-2" outlined>
            <v-slide-group show-arrows>
                <v-slide-item>
                    <cardFormNoticeOfPaymentByCustomer
                        v-if="order.ntpfcs_for_customer.length > 0"
                        class="mx-1"
                    ></cardFormNoticeOfPaymentByCustomer>
                </v-slide-item>
            </v-slide-group>
        </v-sheet>

        <v-alert
            border="top"
            class="pt-5 pl-1 pb-0 mb-2"
            colored-border
            color="yellow darken-3"
            elevation="1"
            @click="clickUpdateRating()"
            v-if="order.status === 9"
        >
            <strong class="ml-2">ให้คะแนนคำสั่งซื้อนี้ของคุณ</strong>
            <v-rating
                empty-icon="star_outline"
                full-icon="star"
                half-icon="star_half"
                hover
                length="5"
                size="24"
                v-model="order.rating"
                color="yellow darken-3"
                background-color="yellow darken-3"
            ></v-rating>
        </v-alert>
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

import uploadImagesForOrder from "@/js/components/guest/uploadImagesForOrder";
import formPayment from "@/js/components/guest/formPayment";
import cardPaymentSummary from "@/js/components/order/cardPaymentSummary";
import cardDataCustomer from "@/js/components/order/cardDataCustomer";
import cardDataOrderDetail from "@/js/components/order/cardDataOrderDetail";
import cardDataGoodsDetail from "@/js/components/order/cardDataGoodsDetail";
import formConditionPayment from "@/js/components/guest/formConditionPayment";
import cardFormNoticeOfPaymentByCustomer from "@/js/components/guest/cardFormNoticeOfPaymentByCustomer";

import { mapGetters } from "vuex";
export default {
    components: {
        uploadImagesForOrder,
        formPayment,
        cardPaymentSummary,
        cardDataCustomer,
        cardDataOrderDetail,
        cardDataGoodsDetail,
        formConditionPayment,
        cardFormNoticeOfPaymentByCustomer,
    },
    data() {
        return {};
    },
    methods: {
        async start() {
            let loader = this.$loading.show();
            const datas = await this.$store.dispatch(
                "orderIndex/getOrderByUUID",
                {
                    uuid: this.$route.params.uuid,
                }
            );
            // this.data = datas.data.order;
            loader.hide();
        },
        status_payment_deadline() {
            const now = new Date();
            const deadlineParse = new Date(this.order.payment_deadline);
            return deadlineParse.valueOf() > now.valueOf();
        },
        ntpfcsLength(v) {
            const ntpfcs = v.filter((v) => {
                return v.status;
            });
            return ntpfcs.length;
        },
        emitStart() {
            this.start();
        },
        async clickUpdateRating() {
            const payload = {
                uuid: this.$route.params.uuid,
                rating: this.order.rating,
            };
            await this.$store
                .dispatch("orderIndex/updateRatingByUuid", payload)
                .then((result) => {
                    this.$toast.success(result.data.text);
                })
                .catch((error) => {
                    console.error(error.message);
                });
        },
        ksherPaySuccess() {
            if (this.$route.query.mch_order_no) {
                this.$swal({
                    title: "ชำระเงินสำเร็จ",
                    text: "ขอบคุณที่ชำระเงิน",
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "เรียบร้อย",
                }).then((response) => {
                    if (response.isConfirmed) {
                        this.start();
                    }
                });
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
