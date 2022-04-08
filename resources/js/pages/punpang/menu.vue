<template>
  <div>
    <h2>รายการสินค้า</h2>
    <p class="text-subtitle-2 mb-1">สั่งซื้อวันนี้ รับราคาพิเศษ</p>
    <p class="text-subtitle-2">
      <strong>*ไม่มีนโยบายคืนเงินทุกกรณี*</strong>
    </p>

    <v-row>
      <v-col
        cols="12"
        sm="6"
        md="4"
        lg="4"
        xl="4"
        v-for="product in products"
        :key="product.id"
      >
        <v-card>
          <v-img :src="`images/menu/${product.img}`"></v-img>
          <v-card-title>
            <h5 class="mb-1">{{ product.products }}</h5>
          </v-card-title>
          <v-card-subtitle class="pb-0">
            <p class="text-caption mb-0">รหัสสินค้า : {{ product.id }}</p>
          </v-card-subtitle>
          <v-card-text>
            <v-simple-table>
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">ราคา</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="price in product.prices" :key="price.id">
                  <td class="text-center">
                    {{ price.size.size }}
                  </td>
                  <td class="text-center">
                    <p class="mb-0 font-weight-black deep-orange--text">
                      {{ price.price | formatNumber }} บาท
                    </p>
                    <p
                      class="mb-0 text-caption text-decoration-line-through"
                      v-if="price.price < price.price_normal"
                    >
                      {{ price.price_normal | formatNumber }} บาท
                    </p>
                  </td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card-text>
          <!-- <v-card-actions v-if="product.product_detail">
            {{ product.product_detail.detail }}
        </v-card-actions> -->
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});

import { mapGetters } from "vuex";
export default {
  data() {
    return {
    //   path: "https://www.punpang.online/images/menu/",
    //   path: "http://192.168.1.103/images/menu/",
    };
  },
  async mounted() {
    let loader = this.$loading.show();
    await this.$store.dispatch("punpangProduct/fetchAllUse");
    loader.hide();
  },
  computed: {
    ...mapGetters({ products: "punpangProduct/fetchAllUse" }),
  },
};
</script>
