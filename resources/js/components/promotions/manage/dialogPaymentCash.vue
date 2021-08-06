<template>
  <div>
    <v-dialog persistent width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="warning mr-2" large>
          <v-icon left>payment</v-icon>
          ชำระเงินสด</v-btn
        >
      </template>
      <v-card>
        <v-card-title> </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6">
              <h4>ยอดชำระทั้งหมด</h4>
            </v-col>
            <v-col cols="12" md="6" class="text-right">
              <h4>{{ propOrder.sum_price_special | formatNumber }} บาท</h4>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <h4>รับเงินสด</h4>
            </v-col>
            <v-col cols="12" md="6" class="text-right">
              <v-text-field
                outlined
                autofocus
                type="number"
                dense
                suffix="บาท"
                hide-details
                v-model="form.payment_amount"
                @change="changePaymentAmount()"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row
            v-if="
              parseFloat(form.payment_amount) -
                parseFloat(propOrder.sum_price_special) >
              0
            "
          >
            <v-col cols="12" md="6">
              <h4>เงินทอน</h4>
            </v-col>
            <v-col cols="12" md="6" class="text-right">
              <h4>
                {{
                  (parseFloat(form.payment_amount) -
                    parseFloat(propOrder.sum_price_special))
                    | formatNumber
                }}
                บาท
              </h4>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-row>
            <v-col cols="12" md="6" class="pa-2">
              <v-btn
                @click="save()"
                color="success"
                x-large
                block
                :disabled="
                  parseFloat(form.payment_amount) -
                    parseFloat(propOrder.sum_price_special) <
                    0 || !form.payment_amount
                "
              >
                <v-icon left>save</v-icon>
                บันทึกรายการ
              </v-btn>
            </v-col>
            <v-col cols="12" md="6" class="pa-2">
              <v-btn color="error" x-large block @click="exit()">
                <v-icon left> exit</v-icon>
                ออก
              </v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
export default {
  props: ["propOrder"],
  data() {
    return {
      dialog: false,
      form: {
        payment_amount: "",
        change: "",
      },
    };
  },
  methods: {
    changePaymentAmount() {
      this.form.change =
        parseFloat(this.propOrder.sum_price_special) -
        parseFloat(this.form.payment_amount);
    },
    async save() {
      let loader = this.$loading.show();
      const form = {
        payment: this.form,
        order: {
          id: this.propOrder.id,
        },
      };

      const res = await this.$store.dispatch("payment/storeCash", form);

      if (res.status === 200) {
        this.$swal({
          title: res.data.msgTitle,
          text: res.data.msgText,
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      } else if (res.status === 201) {
        this.$swal({
          title: res.data.msgTitle,
          text: res.data.msgText,
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      }
      this.exit();
      loader.hide();
      await this.$store.dispatch("promotion/fetchAllByID", {
        id: this.$route.params.id,
      });
    },
    exit() {
      this.dialog = false;
      this.form = {
        payment_amount: "",
        change: "",
      };
    },
  },
};
</script>

<style>
</style>