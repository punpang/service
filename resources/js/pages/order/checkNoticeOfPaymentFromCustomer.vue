<template>
  <div>
    <v-simple-table>
      <thead>
        <tr>
          <th>Order No.</th>
          <th class="text-center">จำนวนเงิน</th>
          <th width="40%" class="text-center">การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="ntpfc in ntpfcs"
          :key="ntpfc.id"
          class="white--text"
          :class="classNtpfc(ntpfc.status)"
        >
          <td >
            <strong class="d-flex flex-row">#{{ ntpfc.order_id }}</strong>
            {{ ntpfc.created_at_th}}
          </td>
          <td class="text-center">
            <strong>{{ ntpfc.amount | formatNumber }} บาท</strong>
          </td>
          <td class="text-right">
            <cardCheckSlip
              :propNtpfc="ntpfc"
              @emitStart="emitStart"
            ></cardCheckSlip>
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import cardCheckSlip from "@/js/components/order/cardCheckSlip";
import { mapGetters } from "vuex";
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
export default {
  components: {
    cardCheckSlip,
  },
  data() {
    return {};
  },
  methods: {
    emitStart() {
      this.start();
    },
    start() {
      this.getNoticeOfPaymentFromCustomer();
    },
    async getNoticeOfPaymentFromCustomer() {
      let loader = this.$loading.show();
      await this.$store.dispatch(
        "orderNoticeOfPaymentFromCustomer/getAllByAdmin"
      );
      loader.hide();
    },
    classNtpfc(v) {
      switch (v) {
        case "create":
          return "blue lighten-1";
        case "success":
          return "green lighten-1";
        case "cancel":
          return "red lighten-1";
      }
    },
  },
  async mounted() {
    await this.start();
  },
  computed: {
    ...mapGetters({
      ntpfcs: "orderNoticeOfPaymentFromCustomer/data",
    }),
  },
};
</script>
