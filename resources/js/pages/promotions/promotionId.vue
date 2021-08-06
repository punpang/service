<template>
  <div v-if="fetchPromotion">
    <v-card class="mb-4">
      <v-card-title>
        <h3>โปรโมชั่น : {{ fetchPromotion.title }}</h3>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6">สั่งซื้อได้ตั้งแต่</v-col>
          <v-col cols="6" class="text-right">
            {{ fetchPromotion.date_start }}
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">หมดเขตสั่งซื้อ/ชำระเงิน</v-col>
          <v-col cols="6" class="text-right">
            {{ fetchPromotion.date_end }}
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">วันที่รับสินค้า</v-col>
          <v-col cols="6" class="text-right">
            {{ fetchPromotion.date_get }}
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <v-card
      class="mb-4"
      v-for="product in fetchPromotion.use_promotion_products"
      :key="product.id"
    >
      <imageThumbnailPathSize800
        :path="product.image"
      ></imageThumbnailPathSize800>
      <v-card-title>
        <h4>
          {{ product.title }}
        </h4>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6"> ราคาปกติ </v-col>
          <v-col cols="6" class="text-right">{{ product.price_normal }}</v-col>
        </v-row>
        <v-row>
          <v-col cols="6"> ราคาพิเศษ </v-col>
          <v-col cols="6" class="text-right">{{ product.price_special }}</v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn
          class="success"
          x-large
          block
          @click="clickAddToShoppingCart(product)"
        >
          เพิ่มลงตะกร้า
        </v-btn>
      </v-card-actions>
    </v-card>

    <shoppingCart
      :propPromotionID="promotion_id"
      :propProducts="products_shopping_cart"
      :propSum="sum"
    ></shoppingCart>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
import shoppingCart from "@/js/components/promotions/shoppingCart";
export default {
  components: {
    imageThumbnailPathSize800,
    shoppingCart,
  },
  data() {
    return {
      products_shopping_cart: [],
      promotion_id: "",
      sum: {
        price_normal: 0,
        price_special: 0,
        discount: 0,
      },
    };
  },
  methods: {
    clickAddToShoppingCart(product) {
      this.products_shopping_cart.push(product);
      this.sum.price_normal =
        this.sum.price_normal + parseFloat(product.price_normal);
      this.sum.price_special =
        this.sum.price_special + parseFloat(product.price_special);
      this.sum.discount = this.sum.price_special - this.sum.price_normal;
    },
  },
  async mounted() {
    let loader = this.$loading.show();
    const res = await this.$store.dispatch(
      "product/fetchByPromotionID",
      this.$route.params.promotion_id
    );
    if (res.status === 201) {
      this.$swal({
        title: res.data.msgTitle,
        text: res.data.msgText,
        confirmButtonText: "รับทราบ",
      });
    }
    this.promotion_id = this.$route.params.promotion_id;
    loader.hide();
  },
  computed: {
    ...mapGetters({ fetchPromotion: "product/fetchByPromotionID" }),
  },
};
</script>