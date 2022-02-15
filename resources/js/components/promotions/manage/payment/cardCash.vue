<template>
  <div v-if="payment.payment_method_id === 2">
    <v-btn x-large color="success" @click="save()">
      <v-icon left>save</v-icon>
      ยืนยันคิวรับสินค้า
    </v-btn>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  methods: {
    async save() {
      let loader = this.$loading.show();
      const res = await this.$store.dispatch(
        "payment/confirmCash",
        this.payment.id
      );

      if (res.status === 200) {
        this.$swal({
          icon: "success",
          title: res.data.msgTitle,
          text: res.data.msgText,
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      } else if (res.status === 201) {
        this.$swal({
          icon: "warning",
          title: res.data.msgTitle,
          text: res.data.msgText,
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      }
      await this.$store.dispatch("promotion/fetchAllByID", {
        id: this.$route.params.id,
      });
      loader.hide();
    },
  },
  computed: {
    ...mapGetters({ payment: "payment/fetchByOrderId" }),
  },
};
</script>
