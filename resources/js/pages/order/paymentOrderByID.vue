<template>
  <div>
    <cardPaymentSummary></cardPaymentSummary>
    <v-text-field
      class="mt-4"
      v-model="amount"
      outlined
      :label="paymentSummary.text.amount"
      large
      :suffix="paymentSummary.text.thb"
      :rules="paymentSummary.rules.amount"
      :readonly="order.status === 8"
      type="number"
      pattern="\d*"
      hide-details
    ></v-text-field>

    <v-container class="mt-3 d-none d-sm-flex">
      <v-row>
        <v-btn @click="window.history.back()" large>
          <v-icon left>arrow_back_ios</v-icon>
          <strong>ย้อนกลับ</strong>
        </v-btn>

        <v-spacer></v-spacer>
        <qrCodeGenerator
          v-if="amount >= 1"
          @emitQrcode="emitQrcode"
          :propTextQRCODE="text_qrCode"
          :propLarge="true"
          :propAmount="amount"
          class="mr-2"
        ></qrCodeGenerator>
        <cardChannelPaymentToPay
          :propLarger="true"
          :propAmount="amount"
          @emitClickSubmitPayment="emitClickSubmitPayment"
          v-if="amount >= 1"
        ></cardChannelPaymentToPay>
        <cardPickupOrder
          @emitPickUpSuccess="emitPickUpSuccess"
          :propLarge="true"
          v-if="order.status === 8 && order.sum_all.sumBalance === 0"
        ></cardPickupOrder></v-row
    ></v-container>
    <!-- ///// -->
    <div class="mt-3 d-sm-none">
      <qrCodeGenerator
        v-if="amount >= 1"
        @emitQrcode="emitQrcode"
        :propTextQRCODE="text_qrCode"
        :propBlock="true"
        :propLarge="true"
        :propAmount="amount"
        class="mb-2"
      ></qrCodeGenerator>
      <v-divider></v-divider>
      <v-row>
        <v-col cols="6"
          ><v-btn @click="backByHistory()" block large>
            <v-icon left>arrow_back_ios</v-icon>
            <strong>ย้อนกลับ</strong>
          </v-btn></v-col
        >
        <v-col cols="6" v-if="amount >= 1"
          ><cardChannelPaymentToPay
            :propAmount="amount"
            :propBlock="true"
            :propLarger="true"
            @emitClickSubmitPayment="emitClickSubmitPayment"
          ></cardChannelPaymentToPay
        ></v-col>
        <v-col
          cols="6"
          v-if="order.status === 8 && order.sum_all.sumBalance === 0"
        >
          <cardPickupOrder></cardPickupOrder>
        </v-col>
      </v-row>
    </div>
    <v-divider></v-divider>
    <cardHistoryPaid></cardHistoryPaid>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import qrCodeGenerator from "@/js/components/order/qrCodeGenerator";
import cardChannelPaymentToPay from "@/js/components/order/cardChannelPaymentToPay";
import cardPickupOrder from "@/js/components/order/cardPickupOrder";
import cardPaymentSummary from "@/js/components/order/cardPaymentSummary";
import cardHistoryPaid from "@/js/components/order/cardHistoryPaid";

export default {
  components: {
    cardPaymentSummary,
    qrCodeGenerator,
    cardChannelPaymentToPay,
    cardPickupOrder,
    cardHistoryPaid,
  },
  data() {
    return {
      amount: 0,
      text_qrCode: "",
    };
  },
  methods: {
    emitPickUpSuccess() {
      // this.backByHistory();
      // this.start();
    },
    async start() {
      let loader = this.$loading.show();
      await this.$store.dispatch("orderIndex/getOrderByID", {
        orderID: this.$route.params.id,
      });
      // if (this.order.sum_all.sumBalance === 0 ) {
      //   this.$swal({
      //     title: "ชำระเงินครบจำนวนแล้ว",a
      //     icon: "info",
      //     allowOutsideClick: false,
      //     confirmButtonText: "รับทราบ",
      //     confirmButtonColor: "#3085d6",
      //   });
      // }
      loader.hide();
    },
    emitClickSubmitPayment(data) {
      this.$swal({
        icon: "warning",
        title: `ตรวจสอบรายละเอียด`,
        html: `<b>ช่องทางชำระเงิน</b> : ${data.channel.text}<br>
        <b>จำนวนเงิน</b> : ${this.amount} บาท<br>
        <b>ยอดคงเหลือหลังชำระ</b> : ${
          this.order.sum_all.sumBalance - this.amount
        } บาท`,
        allowOutsideClick: false,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "รับชำระเงิน",
        showCancelButton: true,
        cancelButtonColor: "#d33",
        cancelButtonText: "ยกเลิก",
      }).then((result) => {
        if (result.isConfirmed) {
          const res = this.processingPayment(data);
        }
      });
      //   console.log(data.channel);
    },

    async processingPayment(data) {
      let loader = this.$loading.show();

      if (this.order.status != 8) {
        data.getGoods = false;
      }

      const payload = {
        orderID: this.order.id,
        amount: this.amount,
        channel: data.channel,
        alertSMS: data.alertSMS,
        getGoods: data.getGoods,
      };
      const res = await this.$store.dispatch(
        "orderIndex/paymentByOrderID",
        payload
      );

      loader.hide();

      if (res.status === 200) {
        this.$swal({
          icon: "success",
          title: res.data.message,
          allowOutsideClick: false,
          confirmButtonText: "เรียบร้อย",
          confirmButtonColor: "#FB8C00",
        }).then((result) => {
          if (result.isConfirmed) {
            this.backByHistory();
          }
        });
      } else if (res.status === 201) {
        this.$swal({
          icon: "error",
          title: "ดำเนินการสำเร็จ",
          text: res.data.message,
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
          confirmButtonColor: "#FB8C00",
        });
      }
    },
    async emitQrcode() {
      await this.generatorQRCODE();
    },
    async generatorQRCODE() {
      if (this.amount < 1) {
        this.$toast.warning("ยอดชำระเงินต้องมากกว่า 1 บาท");
        return;
      }
      this.text_qrCode = "";
      let loader = this.$loading.show();
      const data = {
        amount: this.amount,
      };
      const res = await axios.post(
        "/api/admin/v1/QRCodeGenerator/promptPayQrCodeSCB",
        data
      );
      this.text_qrCode = res.data.full;
      loader.hide();
    },
    setAmount() {
      const deposited = this.order.sum_all.sumDeposited;
      const total = this.order.sum_all.sumTASC;
      if (this.order.status === 8) {
        this.amount = parseInt(this.order.sum_all.sumBalance);
        return;
      }
      if (deposited === 0) {
        this.amount = parseInt(total / 2);
        return;
      } else {
        this.amount = parseInt(total - deposited);
        return;
      }
    },
    backByHistory() {
      return window.history.go(-1);
    },
  },
  async mounted() {
    await this.start();
    await this.setAmount();
  },
  computed: {
    ...mapGetters({
      order: "orderIndex/order",
      paymentSummary: "orderIndex/paymentSummary",
    }),
  },
};
</script>
