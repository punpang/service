<template>
  <div>
    <v-dialog fullscreen width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-bottom-navigation app class="yellow darken-4" grow>
          <v-btn v-on="on" block :disabled="propProducts.length <= 0">
            <span class="white--text"> ตะกร้าสินค้า </span>
            <v-badge
              :content="propProducts.length"
              :value="propProducts.length"
              color="success"
            >
              <v-icon class="white--text">shopping_cart</v-icon>
            </v-badge>
          </v-btn>
        </v-bottom-navigation>
      </template>
      <v-card>
        <v-card-title>
          <h3 class="mb-0">ตะกร้าสินค้า</h3>
          <v-spacer></v-spacer>
          <v-btn fab x-small class="error" @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="pa-2">
          <cardProducts
            :propProducts="propProducts"
            :propSum="propSum"
          ></cardProducts>
          <!-- <sumPriceFreeCount :propSum="propSum" :propProducts="propProducts"></sumPriceFreeCount> -->
          <sumPrice :propSum="propSum" :propProducts="propProducts"></sumPrice>
          <v-form ref="formCustomer" lazy-validation>
            <cardCustomer :propCustomer="customer"></cardCustomer>
          </v-form>

          <v-btn x-large block class="success mb-4" @click="save()"
            >สั่งสินค้า</v-btn
          >
          <v-btn x-large block class="error" @click="dialog = false">ออก</v-btn>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import cardProducts from "@/js/components/promotions/shoppingCart/cardProducts";
import sumPrice from "@/js/components/promotions/shoppingCart/sumPrice";
import sumPriceFreeCount from "@/js/components/promotions/shoppingCart/sumPriceFreeCount";
import cardCustomer from "@/js/components/promotions/shoppingCart/cardCustomer";
export default {
  components: {
    cardProducts,
    sumPrice,
    cardCustomer,
    sumPriceFreeCount
  },
  props: ["propProducts", "propSum", "propPromotionID"],
  data() {
    return {
      dialog: false,
      customer: {
        name: "",
        phone_number: "",
      },
    };
  },
  methods: {
    async save() {
      if (this.propProducts.length <= 0) {
        this.$swal({
          title: "โปรดเลือกสินค้าอย่างน้อย 1 รายการ",
          icon: "warning",
          confirmButtonText: "รับทราบ",
          allowOutsideClick: false,
        });
        return;
      }

      if (this.$refs.formCustomer.validate()) {
        let loader = this.$loading.show();
        const form = {
          customer: this.customer,
          products: this.propProducts,
          sum: this.propSum,
          promotion_id: this.propPromotionID,
        };

        const res = await this.$store.dispatch("order/store", form);

        if (res.status === 200) {
          this.$swal({
            icon: "success",
            title: res.data.msgTitle,
            text: res.data.msgText,
            allowOutsideClick: false,
            confirmButtonText: "รับทราบ",
            confirmButtonColor: "#3085d6",
          }).then((result) => {
            if (result.isConfirmed) {
              this.$router.replace("/order/" + res.data.uuid);
            }
          });

          loader.hide();
        } else if (res.status === 201) {
          loader.hide();
          this.$swal({
            icon: "warning",
            title: res.data.msgTitle,
            text: res.data.msgText,
            allowOutsideClick: false,
            confirmButtonText: "รับทราบ",
            confirmButtonColor: "#3085d6",
          }).then((result) => {
            if (result.isConfirmed) {
              this.$router.replace("/promotions");
            }
          });
        }
      }
    },
  },
};
</script>