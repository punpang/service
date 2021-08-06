<template>
  <div>
    <v-dialog persistent width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="error" block x-large>
          <v-icon left>clear</v-icon>
          ยกเลิกการชำระเงิน</v-btn
        >
      </template>
      <v-card>
        <v-card-text class="pa-5 text-center black--text">
          <h2>ยกเลิกการชำระเงิน</h2>
          <v-form lazy-validation ref="formCancel"></v-form>
          <v-text-field
            v-model="ref2"
            autofocus
            outlined
            label="ref.2"
            :rules="rule"
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-row>
            <v-col cols="6" class="pa-2">
              <v-btn class="success" block x-large @click="save()"
                >ยืนยัน</v-btn
              >
            </v-col>
            <v-col cols="6" class="pa-2">
              <v-btn class="error" block x-large>ออก</v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propPayment"],
  data() {
    return {
      dialog: false,
      ref2: "",
      rule: [(v) => !!v || "ห้ามเว้นว่าง"],
    };
  },
  methods: {
    async save() {
      if (this.ref2 === "") {
        return;
      }

      if (this.$refs.formCancel.validate()) {
        let loader = this.$loading.show();
        const form = {
          ref2: this.ref2,
          payment_id: this.propPayment.id,
        };

        const res = await this.$store.dispatch("payment/cancel", form);

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

        this.$emit("emitRef1");

        loader.hide();
      }
    },
  },
};
</script>