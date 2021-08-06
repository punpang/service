<template>
  <div>
    <v-dialog persistent width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="success mb-4" block x-large
          >ยืนยันการชำระเงิน</v-btn
        >
      </template>
      <v-card>
        <v-card-text class="pa-5 text-center black--text">
          <h2>ยืนยันการชำระเงิน</h2>
        </v-card-text>
        <v-card-actions>
          <v-row>
            <v-col cols="6" class="pa-2">
              <v-btn class="success" block x-large @click="save()"
                >ยืนยัน</v-btn
              >
            </v-col>
            <v-col cols="6" class="pa-2">
              <v-btn class="error" block x-large @click="dialog = false"
                >ออก</v-btn
              >
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propPayment", "propRef1"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async save() {
      this.$emit("emitRef1");
      if (!this.propRef1) {
        this.$swal({
          title: "ref.1 ห้ามว่าง",
          icon: "warning",
          confirmButtonText: "รับทราบ",
        });
        return;
      }
      let loader = this.$loading.show();

      const form = {
        ref1: this.propRef1,
        payment_id: this.propPayment.id,
      };
      const res = await this.$store.dispatch("payment/confirm", form);

      if (res.status === 200) {
        this.$swal({
          title: res.data.msgTitle,
          icon: "success",
          confirmButtonText: "รับทราบ",
        });
        this.dialog = false;
      } else if (res.status === 201) {
        this.$swal({
          title: res.data.msgTitle,
          icon: "warning",
          confirmButtonText: "รับทราบ",
        });
      }
      await this.$store.dispatch("payment/fetchCheck");

      loader.hide();
    },
  },
};
</script>