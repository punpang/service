<template>
  <div>
    <v-file-input
      label="อัปโหลดรูป"
      v-model="propUploadImange.file"
      v-show="!propUploadImange.imagePreview"
      :rules="rules.image"
      prepend-icon="image"
      @change="changeImage"
      accept="image/*"
      outlined
    >
    </v-file-input>
    <v-card v-show="propUploadImange.imagePreview">
      <v-img :src="propUploadImange.imagePreview" class="mb-4">
        <v-btn
          class="mt-1 ml-1"
          color="error"
          @click="clickRemoveImage"
          v-show="propUploadImange.imagePreview"
          fab
          small
        >
          <v-icon>delete</v-icon>
        </v-btn>
      </v-img>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["propUploadImange"], // propUploadImange = uploadImange: { imagePreview: "", file: null,},
  data() {
    return {
      rules: {
        image: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    clickUploadImage() {
      this.image = event.target.files[0];
    },
    async changeImage() {
      this.image = event.target.files[0];
      if (!this.image) {
        return;
      }

      let loader = this.$loading.show();
      this.image = event.target.files[0];
      const formData = new FormData();
      formData.append("image", this.image);
      //console.log(formData);
      const response = await this.$store.dispatch(
        "googleImage/store",
        formData
      );
      if (response.status == 200) {
        this.propUploadImange.imagePreview =
          "https://drive.google.com/thumbnail?id=" + response.data.src_name;
        this.$toast.success("อัปโหลดรูปสำเร็จ");
        //this.form.product_propImageId = response.data.id;
        this.$emit("emitImageId", response.data.id);
        loader.hide();
      } else {
        this.$toast.error("อัปโหลดรูปไม่สำเร็จ เกิดข้อผิดพลาดบางอย่าง");
        loader.hide();
      }
    },
    async clickRemoveImage() {
      let loader = this.$loading.show();
      this.propUploadImange.imagePreview = "";
      this.$emit("emitImageId", "");
      this.$toast.success("ลบรูปภาพสำเร็จ");
      this.propUploadImange.file = null;
      loader.hide();
    },
  },
};
</script>