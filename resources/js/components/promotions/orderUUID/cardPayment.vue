<template>
  <div v-if="propOrder.order_status_id !== 6">
    <v-card class="mb-4">
      <v-card-title>
        <h3>การชำระเงิน</h3>
      </v-card-title>
      <v-card-text class="pt-0" v-if="propOrder.order_status_id === 1">
        <v-form ref="form" lazy-validation>
          <cardFormPayment></cardFormPayment>

          <v-alert type="warning" outlined class="mb-2">
            โปรดชำระเงินด้วยยอด
            {{ propSum.price_special | formatNumber }} บาท
            <strong class="blue--text" @click="cardCondition = !cardCondition"
              >อ่านเงื่อนไขที่นี่ก่อนชำระเงิน</strong
            >
          </v-alert>

          <v-alert type="info" outlined class="mb-2">
            สามารถชำระเงินสดที่หน้าร้านได้ ภายในวันที่กำหนด
          </v-alert>

          <v-card class="mb-2" v-if="cardCondition">
            <v-card-text><cardCondition></cardCondition></v-card-text>
          </v-card>

          <v-card class="mb-2" v-for="book in banks" :key="book.key">
            <!-- <v-img :src="book.logoBank"></v-img> -->
            <v-card-title>
              <h5 class="mb-1">
                {{ book.nameBank }}
              </h5>
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="5"><strong>ชื่อบัญชี</strong> </v-col>
                <v-col cols="7" class="text-right">
                  {{ book.name }}
                </v-col>

                <v-col cols="5">
                  <strong>เลขที่บัญชี</strong>
                </v-col>
                <v-col cols="7" class="text-right">
                  <p class="mb-0">{{ book.number }}</p>

                  <v-btn
                    class="orange"
                    x-small
                    dark
                    v-clipboard:copy="book.numberClipboard"
                    v-clipboard:success="onCopy"
                    >คัดลอก</v-btn
                  >
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-form>
      </v-card-text>

      <v-card-text class="pt-0" v-else>
        <div v-if="propOrder.payment">
          <v-row>
            <v-col cols="6">วันเวลาที่แจ้งชำระเงิน</v-col>
            <v-col cols="6" class="text-right">
              {{ propOrder.payment.payment_status.created_at }}
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6">สถานะการชำระ</v-col>
            <v-col cols="6" class="text-right">
              <v-btn :class="propOrder.payment.payment_status.cssClass" x-small>
                {{ propOrder.payment.payment_status.title }}
              </v-btn>
            </v-col>
          </v-row>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});

import cardCondition from "@/js/components/promotions/orderUUID/cardCondition";
import cardFormPayment from "@/js/components/promotions/orderUUID/cardFormPayment";
export default {
  components: {
    cardFormPayment,
    cardCondition,
  },
  props: ["propSum", "propOrder"],
  data() {
    return {
      cardCondition: false,
      banks: [
        {
          nameBank: "ธนาคารไทยพาณิชย์",
          //   logoBank:
          //     "https://apply.scb.co.th/selfservices/easy-lg/common/img/logo-scb-w.png",
          name: "พรรษิษฐ์ ศรีสุข",
          number: "408-672-0266",
          numberClipboard: "4086720266",
        },
        {
          nameBank: "พร้อมเพย์",
          //   logoBank:
          // "https://apply.scb.co.th/selfservices/easy-lg/common/img/logo-scb-w.png",
          name: "พรรษิษฐ์ ศรีสุข",
          number: "091-885-3402",
          numberClipboard: "0918853402",
        },
      ],
    };
  },
  methods: {
    onCopy() {
      this.$swal({
        title: "คัดลอกแล้ว",
        icon: "success",
        allowOutsideClick: false,
        timerProgressBar: true,
        timer: 3000,
        showConfirmButton: false,
      });
    },
  },
};
</script>