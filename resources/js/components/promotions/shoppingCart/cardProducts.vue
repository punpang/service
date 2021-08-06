<template>
  <div>
    <v-card
      class="pa-0 mb-4"
      v-for="product in propProducts"
      :key="product.key"
    >
      <v-card-text>
        <v-row>
          <v-col cols="4" class="pa-2">
            <imageThumbnailPathSize800
              :path="product.image"
            ></imageThumbnailPathSize800>
          </v-col>
          <v-col cols="8" class="pa-2">
            <h5 class="black--text mb-1">{{ product.title }}</h5>
            <p class="text-body-1 mb-0 font-weight-black deep-orange--text">
              ฿{{ product.price_special }}
            </p>
            <p class="text-caption mb-1 text-decoration-line-through">
              ฿{{ product.price_normal }}
            </p>
            <v-btn x-small class="error" @click="clickRemoveProduct(product)"
              >ลบ</v-btn
            >
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";

export default {
  props: ["propProducts", "propSum"],
  components: {
    imageThumbnailPathSize800,
  },
  data() {
    return {};
  },
  methods: {
    clickRemoveProduct(product) {
      this.propProducts.splice(this.propProducts.indexOf(product), 1);
      this.propSum.price_normal =
        this.propSum.price_normal - parseFloat(product.price_normal);
      this.propSum.price_special =
        this.propSum.price_special - parseFloat(product.price_special);
      this.propSum.discount =
        this.propSum.price_special - this.propSum.price_normal;
    },
  },
};
</script>