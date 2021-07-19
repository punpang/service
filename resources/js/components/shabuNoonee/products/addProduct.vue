<template>
  <div>
    <v-dialog persistent width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="success" fab small>
          <v-icon>add</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <h3>เพิ่มสินค้า</h3>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="(dialog = false), reset()">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-form ref="form" lazy-validation>
            <formAddProduct
              :propForm="form"
              :propUploadImange="uploadImange"
            ></formAddProduct>
          </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="success" rounded @click="save()">
            <v-icon left>save</v-icon>
            บันทึก
          </v-btn>
          <v-btn color="error" rounded @click="reset()">
            <v-icon left>clear</v-icon>
            ล้างข้อมูล
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import formAddProduct from "@/js/components/shabuNoonee/products/_formAddProduct";
export default {
  components: {
    formAddProduct,
  },
  data() {
    return {
      dialog: false,
      uploadImange: {
        imagePreview: "",
        file: null,
      },
      form: {
        title: "",
        product_group_id: "",
        status: true,
        image_id: "",
        price: 0,
        status_free: 1,
        next_to: 4,
      },
    };
  },
  methods: {
    async save() {
      if (this.$refs.form.validate()) {
        const res = await this.$store.dispatch("product/store", this.form);
        if (res.status === 200) {
          this.$toast.success(res.data.message);
          this.reset();
        } else {
          this.$toast.error("ระบบทำงานไม่สำเร็จ");
        }
      }
    },
    reset() {
      this.form = {
        title: "",
        product_group_id: "",
        status: true,
        image_id: "",
        price: 0,
        status_free: 1,
        next_to: 4,
      };
      this.uploadImange = {
        imagePreview: "",
        file: null,
      };
    },
  },
};
</script>