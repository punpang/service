<template>
  <div>
    <h1>ตรวจสอบชำระเงิน</h1>
    <v-row>
      <v-col cols="5"
        ><imageThumbnailPathSize800
          v-if="fetchChecks.image_slip"
          :path="fetchChecks.image_slip"
        ></imageThumbnailPathSize800
      ></v-col>
      <v-col cols="7">
        <h1>{{ fetchChecks.sum_price }} บาท</h1>
        <v-text-field
          v-model="ref1"
          autofocus
          outlined
          label="ref.1"
          :rules="rule"
        ></v-text-field>

        <cardConfirnCheckPayment
          v-if="ref1 && fetchChecks.image_slip"
          :propPayment="fetchChecks"
          :propRef1="ref1"
          @emitRef1="emitRef1"
        ></cardConfirnCheckPayment>
        <cardCancelCheckPayment
          :propPayment="fetchChecks"
          @emitRef1="emitRef1"
        ></cardCancelCheckPayment>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import cardCancelCheckPayment from "@/js/components/promotions/payment/cardCancelCheckPayment";
import cardConfirnCheckPayment from "@/js/components/promotions/payment/cardConfirnCheckPayment";
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
export default {
  data() {
    return {
      ref1: "",
      rule: [(v) => !!v || "ห้ามเว้นว่าง"],
    };
  },
  components: {
    imageThumbnailPathSize800,
    cardConfirnCheckPayment,
    cardCancelCheckPayment,
  },
  methods: {
    async emitRef1() {
      await this.$store.dispatch("payment/fetchCheck");
      this.ref1 = "";
    },
  },
  async mounted() {},

  computed: {
    ...mapGetters({ fetchChecks: "payment/fetchCheck" }),
  },
};
</script>