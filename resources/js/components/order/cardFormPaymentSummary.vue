<template>
  <div>
    <v-simple-table>
      <tbody>
        <tr>
          <td>
            <strong>{{ paymentSummary.text.totalGoods }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sumAll.sumGoods | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr v-if="order.sumAll.sumAccessory > 0">
          <td>
            <strong>{{ paymentSummary.text.accessory }}</strong>
            <p class="text-caption pl-4 mt-1 mb-2">
              {{ order.a_accessory.detail }}
            </p>
          </td>
          <td class="text-right">
            <strong>{{ order.sumAll.sumAccessory | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr v-if="order.sumAll.sumService > 0">
          <td>
            <strong>{{ paymentSummary.text.service }}</strong>
            <p class="text-caption pl-4 mt-1 mb-2">
              {{ order.a_service.detail }}
            </p>
          </td>
          <td class="text-right">
            <strong>{{ order.sumAll.sumService | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr v-if="order.sumAll.sumDiscount > 0">
          <td>
            <strong>{{ paymentSummary.text.discount }}</strong>
          </td>
          <td class="text-right error--text">
            <strong>- {{ order.sumAll.sumDiscount | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr>
          <td>
            <strong>{{ paymentSummary.text.sumTASC }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sumAll.sumTASC | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->
        <tr>
          <td>
            <strong>{{ paymentSummary.text.deposited }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sumAll.sumDeposited | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->
        <tr>
          <td>
            <strong>{{ paymentSummary.text.balance }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sumAll.sumBalance | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->
        <tr>
          <td colspan="2">
            <strong
              >{{ paymentSummary.text.status }} :
              {{ order.a_status.status }}</strong
            >
          </td>
        </tr>
        <!-- / -->
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00");
});
export default {
  data() {
    return {};
  },
  computed: {
    ...mapGetters({
      order: "orderIndex/order",
      paymentSummary: "orderIndex/paymentSummary",
    }),
  },
};
</script>