<template>
  <div>
    <v-alert type="info" v-if="getMore != buyGet">
      เลือกเพิ่ม {{ getMore }} ชิ้น เพื่อรับสิทธิ์ตามโปรโมชั่น
    </v-alert>
    <v-card class="mb-4">
      <v-card-title>
        <h4 class="mb-0">สรุปยอดทั้งหมด</h4>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6" class="py-1">
            <strong>รวมค่าสินค้า</strong> ({{
              propProducts.length
            }}
            ชิ้น)</v-col
          >
          <v-col cols="6 " class="text-right py-1">
            <strong
              >฿{{ parseFloat(propSum.price_special) | formatNumber }}</strong
            >
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6" class="py-1">
            <strong>ส่วนลด</strong> (ฟรี {{ getFree }} ชิ้น)
          </v-col>
          <v-col cols="6" class="text-right py-1">
            <strong class="red--text">฿{{ discount | formatNumber }}</strong>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6" class="py-1"> <strong>ยอดรวมทั้งหมด</strong></v-col>
          <v-col cols="6" class="text-right py-1">
            <strong>฿{{ sumUp | formatNumber }}</strong>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
export default {
  props: ["propSum", "propProducts"],
  data() {
    return {
      getFree: 0,
      getMore: 0,
      buyGet: 0,
    };
  },
  methods: {},
  computed: {
    discount() {
      const products = this.propProducts;
      const buy = 1;
      const get = 1;
      const BG = buy + get;
      this.buyGet = BG;

      let sum = [];
      for (var i = 0; i < products.length; i++) {
        sum.push(parseFloat(products[i].price_special));
      }

      this.getMore = BG - (sum.length / BG - parseInt(sum.length / BG)) * BG;

      const sort = sum.sort((a, b) => a - b);
      const free = parseInt(sort.length / BG) * get;
      this.getFree = free;

      const slice = sort.slice(0, free);
      const reduce = slice.reduce((v, e) => v + e, 0);

      return parseFloat(reduce);
    },
    sumUp() {
      return parseFloat(this.propSum.price_special) - this.discount;
    },
  },
};
</script>