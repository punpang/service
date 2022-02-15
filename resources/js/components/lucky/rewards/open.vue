<template>
  <div>
    <v-dialog width="350" v-model="dialog" persistent>
      <template v-slot:activator="{ on }">
        <v-btn color="info" x-large block v-on="on">
          <strong>เปิดรางวัล</strong>
        </v-btn>
      </template>
      <v-sheet
        class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block"
        color="blue-grey darken-3"
        dark
      >
        <div class="grey--text text--lighten-1 text-body-2 mb-4">
          <strong>คุณต้องการเปิดรางวัลใช่ไหม ?</strong>
          <!-- {{ propOpenReward }} -->
        </div>
        <!-- :disabled="loading" -->
        <v-btn class="ma-1" color="success" plain @click="openReward">
          เปิด
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
  props: ["propOpenReward", "propUuid"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async openReward() {
      if (this.propOpenReward.status_open === 0) {
        let loader = this.$loading.show();

        const data = {
          reward_label_id: this.propOpenReward.id,
          reward_customer_id: this.propOpenReward.reward_customer_id,
          reward_id: this.propOpenReward.reward_id,
          uuid: this.propUuid,
        };

        const res = await this.$store.dispatch(
          "orderLuckyReward/openReward",
          data
        );

        if (res.status === 200 && res.data.success === true) {
          this.propOpenReward.status_open = 1;
          this.$swal({
            title: "เปิดรางวัลแล้ว",
            text:
              "รางวัลของคุณ คือ " +
              '" ' +
              this.propOpenReward.reward.name +
              ' "',
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
        loader.hide();
      }
    },
    close() {
      this.dialog = false;
    },
  },
};
</script>