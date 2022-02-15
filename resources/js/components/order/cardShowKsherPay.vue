<template>
  <div>
    <v-dialog width="600" v-model="dialog" scrollable>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" x-small icon fab class="white--text" elevation="0">
          <v-icon>credit_card</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="text-h6 white--text warning">
          Ksher Pay
          <v-spacer></v-spacer>
          <v-btn elevation="0" @click="clickStart()" class="warning--text">
            <v-icon left>description</v-icon>
            <strong>
              
              ดึงข้อมูล</strong>
          </v-btn>
        </v-card-title>
        <v-card-text class="pa-4">
          <v-simple-table>
            <tbody>
              <tr
                v-for="(value, key) in status ? ksherPay : propKsherPay"
                :key="key"
              >
                <td>
                  <strong>{{ key }}</strong>
                </td>
                <td class="text-right">{{ value }}</td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propKsherPay"],
  data() {
    return {
      dialog: false,
      ksherPay: {
        mch_order_no: null,
      },
      status: false,
    };
  },
  methods: {
    async clickStart() {
      if (this.ksherPay.mch_order_no != null) {
        this.status = !this.status;
        return;
      }

      let loader = this.$loading.show();
      const payload = {
        mch_order_no: this.propKsherPay.mch_order_no,
      };
      const res = await this.$store
        .dispatch(`orderKsher/orderQuery`, payload)
        .then((result) => {
          this.ksherPay = result.data.data;
          this.status = true;
        })
        .catch((err) => {
          this.$toast.error("โปรดตรวจสอบในคอนโซล");
          console.error(err);
        });
      loader.hide();
    },
  },
};
</script>