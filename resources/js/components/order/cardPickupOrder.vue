<template>
  <div>
    <v-dialog
      persistent
      width="400"
      transition="dialog-top-transition"
      v-model="dialog"
    >
      <template v-slot:activator="{ on }">
        <v-btn
          class="warning"
          dark
          :large="propLarge"
          :block="propBlock"
          v-on="on"
          @click="start()"
        >
          <strong>รับสินค้า</strong>
          <v-icon right>local_shipping</v-icon>
        </v-btn>
      </template>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["propLarge", "propBlock"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    start() {
      this.$swal({
        title: "ลูกค้ามารับสินค้าแล้ว",
        icon: "info",
        allowOutsideClick: false,
        confirmButtonText: "รับสินค้า",
        showDenyButton: true,
        denyButtonText: "ยกเลิก",
      }).then((result) => {
        if (result.isConfirmed) {
          this.processingPickUp();
        } else if (result.isDenied) {
          this.dialog = false;
        }
      });
    },

    async processingPickUp() {
      let loader = this.$loading.show();
      const payload = {
        orderID: this.order.id,
      };

      const res = await this.$store.dispatch(
        "orderIndex/pickUpOrderByID",
        payload
      );

      if (res.status === 200) {
        this.$swal({
          title: "ดำเนินการเรียบร้อย",
          icon: "success",
          text: res.data.messages,
          allowOutsideClick: false,
          confirmButtonText: "เรียบร้อย",
        }).then((result) => {
          if (result.isConfirmed) {
            this.$emit("emitPickUpSuccess");
            this.dialog = false;
          }
        });
        loader.hide();
      }
    },
  },
  computed: {
    ...mapGetters({
      order: "orderIndex/order",
    }),
  },
};
</script>