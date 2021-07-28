<template>
  <div>
    <v-dialog persistent v-model="dialog" width="400">
      <template v-slot:activator="{ on }">
        <v-btn
          v-on="on"
          icon
          fab
          x-small
          :disabled="
            propCookingType.status_step_detail_cooking.id != 1 ||
            !propCookingType.status_use
          "
        >
          <v-icon color="error">cancel</v-icon>
        </v-btn>
      </template>
      <v-sheet
        class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block"
        color="blue-grey darken-3"
        dark
      >
        <div class="grey--text text--lighten-1 text-subtitle-1 mb-4">
          ยกเลิกรายการ
          <strong>{{ propCookingType.type_cooking.title }}</strong> ใช่หรือไม่
        </div>

        <v-btn class="ma-1" color="grey" plain @click="dialog = false">
          ออก
        </v-btn>

        <v-btn
          class="ma-1"
          color="error"
          plain
          @click="clickCancelCookingDetail(propCookingType.id)"
        >
          ยืนยัน
        </v-btn>
      </v-sheet>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propCookingType"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async clickCancelCookingDetail(id) {
      let loader = this.$loading.show();

      const res = await this.$store.dispatch(
        "cookingDetail/cancelCookingDetail",
        id
      );

      if (res.status === 200) {
        this.$swal({
          icon: "success",
          title: res.data.msg,
          confirmButtonText: "รับทราบ",
          allowOutsideClick: false,
        });
      } else if (res.status === 201) {
        this.$swal({
          icon: "warning",
          title: res.data.msgTitle,
          text: res.data.msgText,
          confirmButtonText: "รับทราบ",
          allowOutsideClick: false,
        });
      }
      
      this.dialog = false;
      await this.$store.dispatch(
        "cookingDetail/self",
        this.propCookingType.dining_table_id
      );

      loader.hide();
    },
  },
};
</script>