<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <p v-on="on" class="text-subtitle-2 blue--text mb-2 pl-4">ปรับจำนวน</p>
      </template>
      <v-card>
        <v-card-text class="pa-2">
          <h3 class="ml-2 mr-2 mt-4 mb-2 text-center black--text">
            {{ propTableOrderDetail.product.title }}
          </h3>
        </v-card-text>
        <v-card-actions>
          <v-row>
            <v-col class="pr-1 pl-2" cols="3"
              ><v-btn
                outlined
                x-large
                block
                @click="clickCutCount()"
                :disabled="this.propTableOrderDetail.quantity <= 0"
              >
                <h3 class="mb-1">-</h3>
              </v-btn>
            </v-col>
            <v-col class="px-1" cols="6"
              ><v-btn outlined x-large block>
                <h3 class="mb-0">
                  {{ propTableOrderDetail.quantity }}
                </h3></v-btn
              >
            </v-col>
            <v-col class="pl-1 pr-2" cols="3">
              <v-btn
                outlined
                x-large
                block
                @click="clickAddCount()"
                :disabled="this.propTableOrderDetail.quantity === this.quantity"
              >
                <h3 class="mb-1">+</h3>
              </v-btn></v-col
            >
          </v-row>
        </v-card-actions>
        <v-card-actions>
          <v-row>
            <v-col class="px-2">
              <v-btn
                color="success"
                x-large
                block
                @click="save()"
                :disabled="this.propTableOrderDetail.quantity === this.quantity"
              >
                <v-icon left>done</v-icon>
                บันทึก</v-btn
              ></v-col
            >
            <v-col class="px-2">
              <v-btn color="error" x-large block @click="exit()">
                <v-icon left>exit_to_app</v-icon>
                ออก</v-btn
              ></v-col
            >
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propTableOrderDetail"],
  data() {
    return {
      dialog: false,
      quantity: this.propTableOrderDetail.quantity,
    };
  },
  methods: {
    clickCutCount() {
      if (this.propTableOrderDetail.quantity === 0) {
        return;
      }
      --this.propTableOrderDetail.quantity;
    },

    clickAddCount() {
      if (this.propTableOrderDetail.quantity === this.quantity) {
        return;
      }
      ++this.propTableOrderDetail.quantity;
    },
    async save() {
      const form = {
        table_order_detail_id: this.propTableOrderDetail.id,
        quantity: this.propTableOrderDetail.quantity,
      };

      const res = await this.$store.dispatch(
        "tableOrderDetail/updateByWaitress",
        form
      );

      if (res.status === 200) {
        this.$swal({
          title: res.data.msg,
          icon: "success",
          allowOutsideClick: false,
          confirmButtonText: "เรียบร้อย",
        });
      } else if (res.status === 201) {
        this.$swal({
          title: res.data.msg,
          icon: "warning",
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      }

      this.dialog = false;
    },
    exit() {
      this.propTableOrderDetail.quantity = this.quantity;
      this.dialog = false;
    },
  },
};
</script>