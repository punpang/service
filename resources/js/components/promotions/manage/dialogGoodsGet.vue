<template>
  <div>
    <v-dialog persistent width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="success mr-2" large>
          <v-icon left>done</v-icon>
          รับสินค้า</v-btn
        >
      </template>
      <v-sheet
        class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block"
        color="blue-grey darken-3"
        dark
      >
        <div class="grey--text text--lighten-1 text-body-2 mb-4">
          ลูกค้ารับสินค้าแล้วใช่ไหม ?
        </div>
        <v-btn class="ma-1" color="success" x-large plain @click="save()">
          เรียบร้อย
        </v-btn>
        <v-btn @click="exit()" class="ma-1" x-large color="error" plain>
          ออก
        </v-btn>
      </v-sheet>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propOrderID"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async save() {
      let loader = this.$loading.show();
      const res = await this.$store.dispatch(
        "order/updateStatusGoodsGet",
        this.propOrderID
      );

      if (res.status === 200) {
        this.$swal({
          title: res.data.msgTitle,
          text: res.data.msgText,
          icon: res.data.icon,
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      } else {
        this.$swal({
          title: "ไม่สามารถทำงานได้",
          text: "การทำงานผิดพลาด ที่ไม่ทราบสาเหตุ",
          icon: "error",
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      }

      this.exit();

      await this.$store.dispatch("promotion/fetchAllByID", {
        id: this.$route.params.id,
      });

      loader.hide();
    },
    exit() {
      this.dialog = false;
    },
  },
};
</script>

<style>
</style>