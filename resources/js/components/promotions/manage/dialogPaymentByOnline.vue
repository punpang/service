<template>
  <div>
    <v-dialog persistent width="800" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="warning mr-2" large @click="getPayment()">
          <v-icon left>payment</v-icon>
          ตรวจสอบการชำระเงิน</v-btn
        >
      </template>
      <v-card>
        <v-card-title>
          <h4>ตรวจสอบการชำระเงิน</h4>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <cardOnline></cardOnline>
          <cardCash></cardCash>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import cardOnline from "@/js/components/promotions/manage/payment/cardOnline";
import cardCash from "@/js/components/promotions/manage/payment/cardCash";
export default {
  props: ["propOrder"],
  components: {
    cardOnline,
    cardCash,
  },
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async getPayment() {
      let loader = this.$loading.show();
      await this.$store.dispatch("payment/fetchByOrderId", this.propOrder.id);
      loader.hide();
    },
  },
};
</script>

<style>
</style>