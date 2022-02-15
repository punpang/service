<template>
  <div>
    <v-card class="mb-4">
      <v-card-title> <h3>รายการสินค้า</h3> </v-card-title>
      <v-card-text>
        <v-row v-for="orderDetail in propOrderDetails" :key="orderDetail.key">
          <v-col cols="4" class="pa-2">
            <imageThumbnailPathSize200
              :path="orderDetail.product.image"
            ></imageThumbnailPathSize200>
          </v-col>
          <v-col cols="8" class="pa-2">
            <h5 class="black--text mb-1">{{ orderDetail.product.title }}</h5>
            <p class="text-body-1 mb-0 font-weight-black deep-orange--text">
              ฿{{ orderDetail.product.price_special }}
            </p>
            <p class="text-caption mb-1 text-decoration-line-through">
              ฿{{ orderDetail.product.price_normal }}
            </p>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import imageThumbnailPathSize200 from "@/js/components/google/drive/imageThumbnailPathSize200";
export default {
  props: ["propOrderDetails"],
  components: {
    imageThumbnailPathSize200,
  },
};
</script>