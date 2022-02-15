<template>
  <div>
    <v-dialog width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" icon fab x-small>
          <v-icon color="info">details</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title></v-card-title>
        <v-card-text>
          <v-select
            label="สถานะสินค้า"
            outlined
            :items="propOrderStatus"
            item-text="title"
            item-value="id"
            v-model="status_on"
            hide-details
            class="mb-2"
            @change="changeOrderStatus()"
          ></v-select>
          <v-simple-table>
            <thead>
              <tr>
                <th>ชื่อสินค้า</th>
                <th class="text-right">จำนวน</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(count, index) in countProducts.count" :key="index">
                <td>
                  {{ titleProduct(index) }}
                </td>
                <td class="text-right">
                  {{ count.length }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td class="text-right font-weight-bold">
                  รวมทั้งหมด ( {{ sum }} )
                </td>
              </tr>
            </tbody>

            <!-- <tbody>
              <tr v-for="product in countProducts.products" :key="product.id">
                <td>
                  {{ product.title }}
                </td>
                <td>
                  <p
                    class="mb-0"
                    
                  >
                    {{ count.length }}
                  </p>
                </td>
              </tr>
            </tbody> -->
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: [, "propOrderStatus"],
  data() {
    return {
      status_on: "",
      dialog: false,
      sum: 0,
    };
  },
  methods: {
    async changeOrderStatus() {
      let loader = this.$loading.show();
      const form = {
        promotion_id: this.$route.params.id,
        order_status_id: this.status_on,
      };
      await this.$store.dispatch("promotion/countProduct", form);
      this.sumCount();
      loader.hide();
    },
    titleProduct(product_id) {
      const [{ title }] = this.countProducts.products.filter(
        (e) => e.id === parseInt(product_id)
      );

      return title;

      // for (let index = 0; index < products.length; index++) {
      //   if (parseInt(product_id) === parseInt(products[index].id)) {
      //     return products[index].title;
      //   }
      // }
    },
    sumCount() {
      const count = Object.values(this.countProducts.count);
      this.sum = 0;
      for (let index = 0; index < count.length; index++) {
        this.sum += count[index].length;
      }
    },
  },
  computed: {
    ...mapGetters({ countProducts: "promotion/countProduct" }),
  },
};
</script>

<style>
</style>