<template>
  <div>
    <v-simple-table>
      <tbody>
        <tr>
          <td>
            <strong>{{ paymentSummary.text.totalGoods }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sum_all.sumGoods | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr v-if="order.sum_all.sumAccessory > 0">
          <td>
            <strong>{{ paymentSummary.text.accessory }}</strong>
            <p class="text-caption pl-4 mt-1 mb-2">
              {{ order.a_accessory.detail }}
            </p>
          </td>
          <td class="text-right">
            <strong>{{ order.sum_all.sumAccessory | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr v-if="order.sum_all.sumService > 0">
          <td>
            <strong>{{ paymentSummary.text.service }}</strong>
            <p class="text-caption pl-4 mt-1 mb-2">
              {{ order.a_service.detail }}
            </p>
          </td>
          <td class="text-right">
            <strong>{{ order.sum_all.sumService | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr v-if="order.sum_all.sumDiscount > 0">
          <td>
            <strong>{{ paymentSummary.text.discount }}</strong>
          </td>
          <td class="text-right error--text">
            <strong>- {{ order.sum_all.sumDiscount | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->

        <tr>
          <td>
            <strong>{{ paymentSummary.text.sumTASC }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sum_all.sumTASC | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->
        <tr>
          <td>
            <strong>{{ paymentSummary.text.deposited }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sum_all.sumDeposited | formatNumber }}</strong>
          </td>
        </tr>
        <!-- / -->
        <tr>
          <td>
            <strong>{{ paymentSummary.text.balance }}</strong>
          </td>
          <td class="text-right">
            <strong>{{ order.sum_all.sumBalance | formatNumber }}</strong>
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
