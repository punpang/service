<template>
  <div>
    <v-card class="mb-4">
      <v-card-title>
        <h2 class="mb-0">สร้างรายการสั่งซื้อใหม่</h2>
      </v-card-title>
    </v-card>

    <v-row>
      <v-col cols="12" md="4">
        <customerShow @emitCustomer="emitCustomer"></customerShow>
      </v-col>
      <v-col cols="12" md="4">
        <dataTimeGetShow></dataTimeGetShow>
      </v-col>
      <v-col cols="12" md="4">
       
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import customerShow from "@/js/components/order/customer/cardShow/show";
import dataTimeGetShow from "@/js/components/order/dataTimeGet/cardShow/show";

export default {
  components: {
    customerShow,
    dataTimeGetShow,
  },
  data() {
    return {
      customer: "",
    };
  },
  methods: {
    emitCustomer(v) {
      this.customer = v;
    },
  },
  computed: {
    ...mapGetters({}),
  },
};
</script>

<style>
</style>