<template>
  <div>
    <v-dialog persistent width="500" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" icon fab small>
          <v-icon color="warning">edit</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <h3>แก้ไขสินค้า</h3>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-form ref="form" lazy-validation>
            <formAddProduct
              :propForm="propForm"
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
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import formAddProduct from "@/js/components/shabuNoonee/products/_formAddProduct";
export default {
  props: ["propForm"],
  components: {
    formAddProduct,
  },
  data() {
    return {
      dialog: false,
      uploadImange: {
        imagePreview: this.propForm.googlg_image.src_name,
        file: {},
      },
      form: this.propForm,
    };
  },
  methods: {
    async save() {
      if (this.$refs.form.validate()) {
        let loader = this.$loading.show();
        //console.log(this.form);
        const res = await this.$store.dispatch("product/update", this.form);
        if (res.status === 200) {
          this.$toast.success(res.data.message);
          this.dialog = false;
        } else {
          this.$toast.error("ระบบทำงานไม่สำเร็จ");
        }
        loader.hide();
      }
    },
    reset() {
      this.form = this.propForm;
      this.uploadImange = {
        imagePreview: this.propForm.googlg_image.src_name,
        file: null,
      };
    },
  },
};
</script>