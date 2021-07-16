<template>
  <div>
    <h1>{{ self.detail_table }}</h1>
    {{ products }}
    <v-btn color="success" @click="save()">save</v-btn>
    <div v-for="product in productGroupAllow" :key="product.id">
      <v-divider></v-divider>
      <h3>{{ product.name }}</h3>
      <v-divider></v-divider>
      <v-card
        v-for="item_product in product.product"
        :key="item_product.id"
        class="mb-4"
      >
        <v-card-text>
          <v-row>
            <v-col cols="4">
              <imageThumbnailPathSize800WH200
                :path="item_product.googlg_image.src_name"
              ></imageThumbnailPathSize800WH200>
            </v-col>
            <v-col cols="8">
              <h5>
                {{ item_product.title }}
              </h5>
              <v-divider></v-divider>
              <v-alert v-if="item_product.status" dense text type="success">
                <strong>มีสินค้า</strong>
              </v-alert>

              <v-alert v-else dense text type="error">
                <strong>หมดชั่วคราว</strong>
              </v-alert>

              <div v-if="item_product.status">
                <v-btn outlined @click="clickCutProduct(item_product)">
                  <h3>-</h3>
                </v-btn>

                <v-btn disabled>
                  <h3 class="mb-1">
                    {{ countProduct(item_product.id) }}
                  </h3>
                </v-btn>

                <v-btn outlined @click="clickAddProduct(item_product)">
                  <h3>+</h3>
                </v-btn>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import imageThumbnailPathSize800WH200 from "@/js/components/google/drive/imageThumbnailPathSize800WH200";

export default {
  components: {
    imageThumbnailPathSize800WH200,
  },
  data() {
    return {
      products: [],
      sumCountProduct: 0,
    };
  },
  methods: {
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
      this.$swal({
        icon: "success",
        confirmButtonColor:"#3085d6",
        confirmButtonText: "รับทราบ",
        title:"สั่งอาหารสำเร็จ",
        text:"คิวของคุณ #8",
        footer:"สินค้าหมดชั่วคราว : หมูสามชั้นสไลด์",
        allowOutsideClick: false,
      });
      if (this.sumCountProduct === 20) {
        this.$toast.error("สามารถสั่งได้ครั้งละ 20 ถาด");
        return;
      }

      const length = this.products.length;

      if (length == 0) {
        this.products.push({
          id: data.id,
          title: data.title,
          quantity: 1,
          price: data.price,
          sumPrice: data.price * 1,
          status_free: data.status_free,
        });
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
        this.products.push({
          id: data.id,
          title: data.title,
          quantity: 1,
          price: data.price,
          sumPrice: data.price * 1,
          status_free: data.status_free,
        });
        this.sumCountProduct = ++this.sumCountProduct;
      }
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
      const form = {
        diningTableId: this.self.id,
        products: this.products,
        sumCountProduct: this.sumCountProduct,
      };

      const res = await this.$store.dispatch("tableOrder/store", form);

      this.reset();
      console.log(res);
    },
    reset() {
      this.products = [];
      this.sumCountProduct = 0;
    },
  },
  async mounted() {
    await this.$store.dispatch("tableOrder/self");
  },
  computed: {
    ...mapGetters({ self: "tableOrder/self" }),
    ...mapGetters({ productGroupAllow: "tableOrder/productGroupAllow" }),
  },
};
</script>