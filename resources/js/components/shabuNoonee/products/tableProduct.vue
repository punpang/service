<template>
  <div>
    <v-text-field
      v-model="search"
      label="ค้นหา"
    ></v-text-field>
    <v-data-table
      :headers="headers"
      :items="products"
      item-key="id"
      class="elevation-1"
      :search="search"
      :items-per-page="999"
      hide-default-footer
      group-by="product_group.name"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>
              
            <h2>สินค้า</h2>
          </v-toolbar-title>

          <v-spacer></v-spacer>
          <addProduct></addProduct>
        </v-toolbar>
      </template>
      <template v-slot:item.image_id="{ item }">
        <v-card></v-card>
        <googleImage :path="item.googlg_image.src_name"></googleImage>
      </template>

      <template v-slot:item.product_group="{ item }">
        {{ item.product_group.name }}
      </template>

      <template v-slot:item.status="{ item }">
        <div v-if="item.status === 1" class="text-success">ใช้งาน</div>
        <div v-else class="text-danger">ไม่ใช้งาน</div>
      </template>

      <template v-slot:item.manage="{ item }">
        <updateProduct :propForm="item"></updateProduct>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import addProduct from "@/js/components/shabuNoonee/products/addProduct";
import updateProduct from "@/js/components/shabuNoonee/products/updateProduct";

import { mapGetters } from "vuex";
import googleImage from "@/js/components/google/drive/imageThumbnailPathSize800WH200";

export default {
  components: {
    googleImage,
    addProduct,
    updateProduct,
  },
  data() {
    return {
      search: "",
      headers: [
        { text: "รูปภาพ", value: "image_id" },
        { text: "ชื่อสินค้า", value: "title" },
        { text: "กลุ่มสินค้า", value: "product_group" },
        { text: "สถานะ", value: "status" },
        { text: "การจัดการ", value: "manage" },
      ],
    };
  },
  async mounted() {
    let loader = this.$loading.show();
    await this.$store.dispatch("product/all");
    loader.hide();
  },
  computed: {
    ...mapGetters({ products: "product/all" }),
  },
};
</script>
