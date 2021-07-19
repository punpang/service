<template>
  <div>
    <uploadImage
      @emitImageId="emitImageId"
      :propUploadImange="propUploadImange"
    ></uploadImage>
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
    <v-text-field
      outlined
      label="ราคา/หน่วย"
      v-model="propForm.price"
      :rules="rules.price"
      type="number"
      pattern="\d*"
    ></v-text-field>
    <v-select
      outlined
      label="ส่งงานต่อ"
      v-model="propForm.next_to"
      :items="nextTos"
      item-text="name"
      item-value="id"
      :rules="rules.next_to"
    ></v-select>

    <v-switch label="ใช้งาน" v-model="propForm.status"></v-switch>
    <v-switch
      label="ไม่มีค่าใช้จ่ายสำหรับบุฟเฟต์"
      v-model="propForm.status_free"
    ></v-switch>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import uploadImage from "@/js/components/google/drive/uploadImage";
export default {
  props: ["propForm", "propUploadImange"],
  components: {
    uploadImage,
  },
  data() {
    return {
      rules: {
        title: [(v) => !!v || "ห้ามเว้นว่าง"],
        product_group_id: [(v) => !!v || "ห้ามเว้นว่าง"],
        price: [(v) => !!v || "ห้ามเว้นว่าง"],
        next_to: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  async mounted() {
    await this.$store.dispatch("productGroup/all");
    await this.$store.dispatch("userType/nextTo");
  },
  computed: {
    ...mapGetters({ productGroups: "productGroup/all" }),
    ...mapGetters({ nextTos: "userType/nextTo" }),
  },
  methods: {
    emitImageId(v) {
      this.propForm.image_id = v;
    },
  },
};
</script>