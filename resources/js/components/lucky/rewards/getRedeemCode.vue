<template>
  <div>
    <v-dialog width="350" v-model="dialog" persistent>
      <template v-slot:activator="{ on }">
        <v-btn color="warning" x-large block class="mt-3" v-on="on">
          <strong>รับรหัส Redeem Code</strong>
        </v-btn>
      </template>
      <v-sheet
        class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block"
        color="blue-grey darken-3"
        dark
      >
        <div class="grey--text text--lighten-1 text-body-2 mb-4">
          <strong>คุณต้องการรับรหัส Redeem Code ใช่ไหม ?</strong>
          <!-- {{ propGetRedeemCode }} -->
        </div>
        <!-- :disabled="loading" -->
        <v-btn class="ma-1" color="success" plain @click="getRedeemCode">
          รับรหัส
        </v-btn>
        <!-- :loading="loading"
          @click="remove" -->
        <v-btn class="ma-1" color="error" plain @click="close"> ออก </v-btn>
      </v-sheet>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: ["propGetRedeemCode", "propUuid"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async getRedeemCode() {
      if (
        this.propGetRedeemCode.status_open === 1 &&
        this.propGetRedeemCode.status_use_redeem_code === 0
      ) {
        let loader = this.$loading.show();
        const data = {
          reward_label_id: this.propGetRedeemCode.id,
          reward_customer_id: this.propGetRedeemCode.reward_customer_id,
          reward_id: this.propGetRedeemCode.reward_id,
          uuid: this.propUuid,
        };

        const res = await this.$store.dispatch(
          "orderLuckyReward/getRedeemCode",
          data
        );

        if (res.status === 200 && res.data.success === true) {
          this.propGetRedeemCode.status_open = 1;
          this.$swal({
            title: "รับรหัสลับ Redeem Code",
            text: res.data.message,
            icon: "success",
            allowOutsideClick: false,
            confirmButtonText: `รับทราบ`,
          });
        } else if (res.status === 201 && res.data.error === true) {
          this.$swal({
            title: res.data.message,
            icon: "error",
            allowOutsideClick: false,
            confirmButtonText: `รับทราบ`,
          });
        }
        this.close();
        loader.hide();
      }
    },
    close() {
      this.dialog = false;
    },
  },
};
</script>