<template>
  <div>
    <v-alert
      v-if="fetchByUUID.order_status"
      :color="fetchByUUID.order_status.cssClass"
      dark
    >
      <h2 class="mb-0 py-2">
        {{ fetchByUUID.order_status.title }}
      </h2>
    </v-alert>
    <cardOrderInformation :propOrder="fetchByUUID"></cardOrderInformation>
    <cardCustomer :propCustomer="fetchByUUID.customer"></cardCustomer>
    <cardPayment :propSum="sum" :propOrder="fetchByUUID"></cardPayment>
    <cardOrderDetails
      :propOrderDetails="fetchByUUID.order_details"
    ></cardOrderDetails>
    <cardSum
      :propSum="fetchByUUID"
      :propProducts="fetchByUUID.order_details"
    ></cardSum>
  </div>
</template>

<script>
import cardCustomer from "@/js/components/promotions/orderUUID/cardCustomer";
import cardOrderDetails from "@/js/components/promotions/orderUUID/cardOrderDetails";
import cardSum from "@/js/components/promotions/orderUUID/cardSum";
import cardPayment from "@/js/components/promotions/orderUUID/cardPayment";
import cardOrderInformation from "@/js/components/promotions/orderUUID/cardOrderInformation";

import { mapGetters } from "vuex";
export default {
  components: {
    cardCustomer,
    cardOrderDetails,
    cardSum,
    cardPayment,
    cardOrderInformation,
  },
  data() {
    return {
      sum: {},
    };
  },
  async mounted() {
    let loader = this.$loading.show();
    await this.$store.dispatch("order/fetchByUUID", this.$route.params.uuid);
    this.sum = {
      price_normal: this.fetchByUUID.sum_price_normal,
      price_special: this.fetchByUUID.sum_price_special,
      discount: this.fetchByUUID.sum_discount,
    };
    loader.hide();
    if (this.fetchByUUID.order_status_id === 1) {
      this.$swal({
        title: "โปรดยืนยันการสั่งซื้อ",
        text:
          "โปรดชำระเงินและแจ้งชำระเงิน ภายในวันที่ " +
          this.fetchByUUID.promotion.date_end,
        icon: "warning",
        allowOutsideClick: false,
        confirmButtonText: "รับทราบ",
        footer: "โปรดอ่านเงื่อนไขในหัวข้อ การชำระเงิน ก่อนทำการชำระเงิน",
      });
    } else if (this.fetchByUUID.order_status_id === 3) {
      this.$swal({
        title: "สั่งซื้อสำเร็จ",
        text:
          "วันเวลานัดรับของท่าน คือ " +
          this.fetchByUUID.promotion.date_get +
          " " +
          this.fetchByUUID.time_get +
          " น.",
        icon: "success",
        allowOutsideClick: false,
        confirmButtonText: "รับทราบ",
      });
    } else if (this.fetchByUUID.order_status_id === 6) {
      this.$swal({
        title: "ยกเลิกรายการแล้ว",
        text: "หากไม่ถูกต้อง โทร. 091-885-3402",
        icon: "error",
        allowOutsideClick: false,
        confirmButtonText: "รับทราบ",
      });
    }
  },
  computed: {
    ...mapGetters({ fetchByUUID: "order/fetchByUUID" }),
  },
};
</script>