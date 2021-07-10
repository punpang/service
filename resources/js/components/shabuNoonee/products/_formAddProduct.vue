<template>
  <div>
    <uploadImage @emitImageId="emitImageId" :propUploadImange="propUploadImange"></uploadImage>
    <v-text-field
      outlined
      label="ชื่อสินค้า"
      v-model="propForm.title"
      :rules="rules.title"
    ></v-text-field>
    <v-select
      outlined
      label="กลุ่มสินค้า"
      v-model="propForm.product_group_id"
      :items="productGroups"
      item-text="name"
      item-value="id"
      :rules="rules.product_group_id"
    ></v-select>
    <v-switch
      label="สถานะ"
      v-model="propForm.status"
    ></v-switch>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import uploadImage from "@/js/components/google/drive/uploadImage";
export default {
  props: ["propForm" , "propUploadImange"],
  components: {
    uploadImage,
  },
  data() {
    return {
      rules: {
        title: [(v) => !!v || "ห้ามเว้นว่าง"],
        product_group_id: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  mounted() {
    this.$store.dispatch("productGroup/all");
  },
  computed: {
    ...mapGetters({ productGroups: "productGroup/all" }),
  },
  methods: {
    emitImageId(v) {
      this.propForm.image_id = v;
    },
  },
};
</script>