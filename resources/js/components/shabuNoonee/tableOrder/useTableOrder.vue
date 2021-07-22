<template>
  <div>
    <div v-for="product in productGroupAllow" :key="product.id">
      <v-divider></v-divider>
      <h3>{{ product.name }}</h3>
      <v-divider></v-divider>
      <v-card
        v-for="item_product in product.product"
        :key="item_product.id"
        class="mb-4"
        outlined
        :disabled="item_product.status == false"
        shaped
        elevation="2"
        :color="colorCardByCountProduct(countProduct(item_product.id))"
      >
        <v-card-text>
          <v-row>
            <v-col cols="4">
              <imageThumbnailPathSize800WH200
                :path="item_product.googlg_image.src_name"
              ></imageThumbnailPathSize800WH200>
            </v-col>
            <v-col cols="8">
              <h5 class="mb-4">
                <strong>{{ item_product.title }}</strong>
                <strong v-if="item_product.status_free === 0"
                  >( {{ item_product.price }} บาท )</strong
                >
              </h5>
              <v-alert v-if="item_product.status" dense text type="success">
                <strong>มีสินค้า</strong>
              </v-alert>

              <v-alert v-else dense text type="error">
                <strong>หมดชั่วคราว</strong>
              </v-alert>

              <div v-if="item_product.status">
                <v-btn small outlined @click="clickCutProduct(item_product)">
                  <h3>-</h3>
                </v-btn>

                <v-btn small disabled>
                  <h3 class="mb-1">
                    {{ countProduct(item_product.id) }}
                  </h3>
                </v-btn>

                <v-btn small outlined @click="clickAddProduct(item_product)">
                  <h3>+</h3>
                </v-btn>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </div>
    <v-bottom-navigation app class="yellow darken-4" grow>
      <v-btn>
        <span class="white--text">เรียกเก็บเงิน</span>

        <v-icon class="white--text">attach_money</v-icon>
      </v-btn>
      <v-btn @click="save()">
        <span class="white--text">สั่งอาหาร</span>
        <v-badge
          :content="sumCountProduct"
          :value="sumCountProduct"
          :color="colorBadgeSumProduct(sumCountProduct)"
        >
          <v-icon class="white--text">restaurant_menu</v-icon>
        </v-badge>
      </v-btn>
      <v-btn>
        <span class="white--text">เรียกพนักงาน</span>

        <v-icon class="white--text">people_alt</v-icon>
      </v-btn>
    </v-bottom-navigation>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import imageThumbnailPathSize800WH200 from "@/js/components/google/drive/imageThumbnailPathSize800WH200";

export default {
  components: {
    imageThumbnailPathSize800WH200,
    //qrCode <qrCode text="http://192.168.1.103:8000/table"></qrCode>
  },
  data() {
    return {
      products: [],
      sumCountProduct: 0,
    };
  },
  methods: {
    colorCardByCountProduct(c) {
      if (c == 0) {
        return;
      }
      return "lime lighten-5";
    },
    colorBadgeSumProduct(c) {
      if (c >= 20) {
        return "deep-orange darken-4";
      } else if (c >= 15) {
        return "yellow darken-3";
      } else if (c > 0) {
        return "green";
      }
    },
    countProduct(v) {
      const length = this.products.length;
      for (let i = 0; i < length; i++) {
        if (this.products[i].id == v) {
          return this.products[i].quantity;
        }
      }
      return 0;
    },
    clickAddProduct(data) {
      if (this.sumCountProduct === 20) {
        this.$swal({
          icon: "warning",
          title: "สามารถสั่งได้ครั้งละ 20 ถาด",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ปิด",
          allowOutsideClick: false,
        });
        return;
      }

      const length = this.products.length;

      if (length == 0) {
        this.productPush(data);
        this.sumCountProduct = 1;
      } else {
        for (let i = 0; i < length; i++) {
          if (this.products[i].id == data.id) {
            this.products[i].quantity = ++this.products[i].quantity;
            this.products[i].sumPrice =
              this.products[i].price * this.products[i].quantity;
            this.sumCountProduct = ++this.sumCountProduct;
            return;
          }
        }

        this.productPush(data);
        this.sumCountProduct = ++this.sumCountProduct;
      }
    },
    productPush(data) {
      this.products.push({
        id: data.id,
        title: data.title,
        next_to: data.next_to,
        quantity: 1,
        price: data.price,
        sumPrice: data.price * 1,
        status_free: data.status_free,
      });
    },
    clickCutProduct(data) {
      const length = this.products.length;
      for (let i = 0; i < length; i++) {
        if (this.products[i].id == data.id) {
          if (this.products[i].quantity === 0) {
            return;
          }
          this.products[i].quantity = --this.products[i].quantity;
          this.products[i].sumPrice =
            this.products[i].price * this.products[i].quantity;
          this.sumCountProduct = --this.sumCountProduct;

          return;
        }
      }
    },
    async save() {
      if (this.sumCountProduct <= 0) {
        this.$swal({
          icon: "warning",
          title: "โปรดเพิ่มอาหารอย่างน้อย 1 รายการ",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ปิด",
          allowOutsideClick: false,
        });
        return;
      }

      let loader = this.$loading.show();
      const form = {
        diningTableId: this.self.id,
        products: this.products,
        sumCountProduct: this.sumCountProduct,
      };

      const res = await this.$store.dispatch("tableOrder/store", form);
      if (res.status === 200) {
        this.$swal({
          icon: "success",
          confirmButtonColor: "#3085d6",
          timer: 5000,
          timerProgressBar: true,
          showConfirmButton: false,
          title: res.data.message,
          text: res.data.queue,
          footer: res.data.messageProductOutOfStock,
          allowOutsideClick: false,
        });
        this.reset();
      } else if (res.status === 201) {
        this.$swal({
          icon: "error",
          title: res.data.message,
          text: res.data.messageText,
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ปิด",
          allowOutsideClick: false,
        });

        if (res.data.resetStatus) {
          await this.$store.dispatch("tableOrder/self");
        }
      }
      loader.hide();
    },
    reset() {
      this.products = [];
      this.sumCountProduct = 0;
    },
  },
  async mounted() {
    await this.$store.dispatch(
      "tableOrder/productGroupAllow",
      this.self.price_range.product_group_allow
    );
  },
  computed: {
    ...mapGetters({ self: "tableOrder/self" }),
    ...mapGetters({ productGroupAllow: "tableOrder/productGroupAllow" }),
  },
};
</script>