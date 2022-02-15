<template>
  <div>
    <v-dialog persistent width="800" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" icon fab color="info" @click="start()">
          <v-icon>search</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="mb-4">
          <!-- 1 -->
          <dialogPaymentCash
            v-if="order.order_status_id === 1"
            :propOrder="order"
          ></dialogPaymentCash>

          <!-- 2 -->
          <dialogPaymentByOnline
            v-else-if="order.order_status_id === 2"
            :propOrder="order"
          ></dialogPaymentByOnline>

          <!-- 3 -->
          <dialogGoodsDone
            :propOrderID="order.id"
            v-else-if="order.order_status_id === 3"
          ></dialogGoodsDone>

          <!-- 4 -->
          <dialogGoodsGet
            v-else-if="order.order_status_id === 4"
            :propOrderID="order.id"
          ></dialogGoodsGet>

          <v-btn class="error" large v-if="order.order_status_id < 3">
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
              ><cardCustomer :propCustomer="order.customer"></cardCustomer
            ></v-col>
            <v-col cols="12" md="6"><cardSum :propSum="order"></cardSum></v-col>

            <v-col cols="12" md="12">
              <cardOrderDetails
                :propOrderDetails="order.order_details"
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
import dialogGoodsDone from "@/js/components/promotions/manage/dialogGoodsDone";
import dialogPaymentCash from "@/js/components/promotions/manage/dialogPaymentCash";
import dialogGoodsGet from "@/js/components/promotions/manage/dialogGoodsGet";
import { mapGetters } from "vuex";
export default {
  props: ["propOrder"],
  components: {
    cardCustomer,
    cardSum,
    cardOrderDetails,
    dialogPaymentCash,
    dialogPaymentByOnline,
    dialogGoodsDone,
    dialogGoodsGet,
  },
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async start() {
      let loader = this.$loading.show();
      await this.$store.dispatch("order/fetchByID", this.propOrder.id);
      loader.hide();
    },
  },
  computed: {
    ...mapGetters({ order: "order/fetchByID" }),
  },
};
</script>

<style>
</style>