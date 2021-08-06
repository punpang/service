<template>
  <div>
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
              >฿{{ parseFloat(propSum.price_normal) | formatNumber }}</strong
            >
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6" class="py-1"> <strong>ส่วนลด</strong></v-col>
          <v-col cols="6" class="text-right py-1">
            <strong class="red--text"
              >฿{{ parseFloat(propSum.discount) | formatNumber }}</strong
            >
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6" class="py-1"> <strong>ยอดรวมทั้งหมด</strong></v-col>
          <v-col cols="6" class="text-right py-1">
            <strong
              >฿{{ parseFloat(propSum.price_special) | formatNumber }}</strong
            >
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
};
</script>