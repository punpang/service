<template>
  <div>
    <v-dialog persistent width="800" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="warning mr-2" large @click="getPayment()">
          <v-icon left>payment</v-icon>
          ตรวจสอบการชำระเงิน</v-btn
        >
      </template>
      <v-card>
        <v-card-title>
          <h4>ตรวจสอบการชำระเงิน</h4>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text v-if="payment.image_slip">
          <v-row>
            <v-col cols="12" md="7">
              <imageThumbnailPathSize800
                :path="payment.image_slip"
              ></imageThumbnailPathSize800>
            </v-col>

            <v-col cols="12" md="5">
              <v-form lazy-validation ref="formPaymentOnline">
                <v-text-field
                  outlined
                  label="จำนวนเงิน"
                  suffix="บาท"
                  type="number"
                  autofocus
                  v-model="form.payment_amount"
                  :rules="rules.payment_amount"
                ></v-text-field>
                <v-text-field
                  outlined
                  label="ref.1"
                  v-model="form.ref1"
                  :rules="rules.ref1"
                ></v-text-field>
                <v-text-field
                  outlined
                  label="ref.2"
                  v-model="form.ref2"
                  :rules="rules.ref2"
                ></v-text-field>

                <v-btn
                  class="success mb-4"
                  block
                  x-large
                  @click="save()"
                  :disabled="
                    parseFloat(form.payment_amount) !==
                    parseFloat(payment.sum_price)
                  "
                >
                  <v-icon left>payment</v-icon>
                  ยืนยันการชำระเงิน</v-btn
                >

                <cardCancelCheckPayment
                  :propPayment="payment"
                  @emitRef1="emitRef1"
                ></cardCancelCheckPayment>
              </v-form>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
import cardCancelCheckPayment from "@/js/components/promotions/payment/cardCancelCheckPayment";

export default {
  props: ["propOrder"],
  components: {
    imageThumbnailPathSize800,
    cardCancelCheckPayment,
  },
  data() {
    return {
      dialog: false,
      rules: {
        payment_amount: [(v) => !!v || "ห้ามเว้นว่าง"],
        ref1: [(v) => !!v || "ห้ามเว้นว่าง"],
        ref2: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
      form: {
        payment_amount: "",
        ref1: "",
        ref2: "",
        id: "",
      },
    };
  },
  methods: {
    async getPayment() {
      let loader = this.$loading.show();
      await this.$store.dispatch("payment/fetchByOrderId", this.propOrder.id);
      this.form.id = this.payment.id;
      loader.hide();
    },
    async emitRef1() {
      await this.$store.dispatch("promotion/fetchAllByID", {
        id: this.$route.params.id,
      });
      this.clear();
    },
    clear() {
      this.dialog = false;
      this.form = {
        payment_amount: "",
        ref1: "",
        ref2: "",
        id: "",
      };
    },
    async save() {
      if (!this.$refs.formPaymentOnline.validate()) {
        return;
      }

      let loader = this.$loading.show();
      const res = await this.$store.dispatch(
        "payment/confirmOnline",
        this.form
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
      this.clear();
      loader.hide();
    },
  },
  computed: {
    ...mapGetters({ payment: "payment/fetchByOrderId" }),
  },
};
</script>

<style>
</style>