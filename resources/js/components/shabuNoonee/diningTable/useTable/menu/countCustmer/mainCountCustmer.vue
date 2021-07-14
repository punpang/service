<template>
  <v-dialog v-model="dialog" persistent width="500">
    <template v-slot:activator="{ on }">
      <v-card v-on="on" color="green accent-3">
        <v-card-text class="white--text text-center">
          <h3 class="ma-3">จำนวนลูกค้า</h3>
        </v-card-text>
      </v-card>
    </template>

    <v-card>
      <v-card-title></v-card-title>
      <v-card-text>
        <countCustomer :propformCount="table"></countCustomer>
      </v-card-text>
      <v-card-actions>
        <v-row>
          <v-col class="px-2">
            <v-btn color="success" x-large block @click="save()">
              <v-icon left>local_dining</v-icon>
              บันทึก</v-btn
            ></v-col
          >
          <v-col class="px-2">
            <v-btn color="error" x-large block @click="exit()">
              <v-icon left>exit_to_app</v-icon>
              ออก</v-btn
            ></v-col
          >
        </v-row></v-card-actions
      >
    </v-card>
  </v-dialog>
</template>

<script>
import countCustomer from "@/js/components/shabuNoonee/diningTable/addTable/countCustomer";

export default {
  components: {
    countCustomer,
  },
  props: ["table"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async exit() {
      this.dialog = false;
      let loader = this.$loading.show();
      await this.$store.dispatch("diningTable/table", this.table.id);
      loader.hide();
    },
    async save() {
      if (this.table.sumCountCustomer !== 0) {
        let loader = this.$loading.show();
        const res = await this.$store.dispatch(
          "diningTable/tableUpdate",
          this.table
        );
        if (res.status === 200) {
          this.dialog = false;
          this.$toast.success(res.data.message);
        } else {
          this.$toast.error("ระบบทำงานไม่สำเร็จ");
        }
        loader.hide();
      } else {
        this.$toast.warning("จำนวนลูกค้าไม่ถูกต้อง");
      }
    },
  },
};
</script>