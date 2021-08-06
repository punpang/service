<template>
  <div>
    <v-dialog persistent width="800" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" icon fab color="info">
          <v-icon>search</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="mb-4">
          <!-- 1 -->
          <dialogPaymentCash
            v-if="propOrder.order_status_id === 1"
            :propOrder="propOrder"
          ></dialogPaymentCash>

          <!-- 2 -->
          <dialogPaymentByOnline
            v-else-if="propOrder.order_status_id === 2"
            :propOrder="propOrder"
          ></dialogPaymentByOnline>

          <!-- 3 -->
          <v-btn
            class="success mr-2"
            large
            v-else-if="propOrder.order_status_id === 3"
          >
            <v-icon left>payment</v-icon>
            จัดเตรียมสินค้า</v-btn
          >
          <!-- 4 -->
          <v-btn
            class="success mr-2"
            large
            v-else-if="propOrder.order_status_id === 4"
          >
            <v-icon left>payment</v-icon>
            รับสินค้า</v-btn
          >
          <v-btn class="error" large v-if="propOrder.order_status_id < 3">
            <v-icon left>cancel</v-icon>
            ยกเลิกรายการ</v-btn
          >
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6"
              ><cardCustomer :propCustomer="propOrder.customer"></cardCustomer
            ></v-col>
            <v-col cols="12" md="6"
              ><cardSum :propSum="propOrder"></cardSum
            ></v-col>

            <v-col cols="12" md="12">
              <cardOrderDetails
                :propOrderDetails="propOrder.order_details"
              ></cardOrderDetails>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import cardCustomer from "@/js/components/promotions/orderUUID/cardCustomer";
import cardSum from "@/js/components/promotions/orderUUID/cardSum";
import cardOrderDetails from "@/js/components/promotions/orderUUID/cardOrderDetails";
import dialogPaymentByOnline from "@/js/components/promotions/manage/dialogPaymentByOnline";

import dialogPaymentCash from "@/js/components/promotions/manage/dialogPaymentCash";

export default {
  props: ["propOrder"],
  components: {
    cardCustomer,
    cardSum,
    cardOrderDetails,
    dialogPaymentCash,
    dialogPaymentByOnline,
  },
  data() {
    return {
      dialog: false,
    };
  },
};
</script>

<style>
</style>