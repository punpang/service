<template>
  <div>
    <v-card outlined class="mb-3">
      <v-card-title class="text-h6 white--text warning">
        {{ paymentSummary.text.title }}{{ order.id }}
      </v-card-title>
      <v-card-text>
        <cardFormPaymentSummary></cardFormPaymentSummary>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import cardFormPaymentSummary from "@/js/components/order/cardFormPaymentSummary";

export default {
  components: {
    cardFormPaymentSummary,
  },
  computed: {
    ...mapGetters({
      order: "orderIndex/order",
      paymentSummary: "orderIndex/paymentSummary",
    }),
  },
};
</script>