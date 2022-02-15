<template>
  <div>
    <v-file-input
      multiple
      label="อัปโหลดรูป"
      v-model="propUploadImange.file"
      :rules="rules.image"
      prepend-icon="image"
      @change="changeImage"
      accept="image/*"
      outlined
    >
    </v-file-input>
    <v-card v-show="propUploadImange">
      <v-img
        v-for="img in propUploadImange"
        :key="img.id"
        :src="
          'https://drive.google.com/thumbnail?id=' +
          img.google_image.src_name +
          '&sz=w800-h800'
        "
        :lazy-src="
          'https://drive.google.com/thumbnail?id=' +
          img.google_image.src_name +
          '&sz=w800-h800'
        "
        class="mb-4"
      >
        <v-btn
          class="mt-2 ml-2"
          color="error"
          @click="clickRemoveImage(img.id)"
          v-show="img"
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
      limitUpload: 13,
    };
  },
  methods: {
    clickUploadImage() {
      this.image = event.target.files[0];
    },
    async changeImage(images) {
      if (images.length < 1) {
        return;
      }

      if (this.propUploadImange.length !== undefined) {
        const count = images.length + this.propUploadImange.length;
        if (count > this.limitUpload) {
          const diff = this.limitUpload - this.propUploadImange.length;
          this.$swal({
            title: "จำนวนรูปภาพมากเกินไป",
            text: "คุณสามารถอัปโหลดเพิ่มได้อีก " + diff + " รูป",
            allowOutsideClick: false,
            confirmButtonText: "รับทราบ",
            icon: "warning",
          });
          return;
        }
      }

      if (images.length > this.limitUpload) {
        this.$swal({
          title: "จำนวนรูปภาพมากเกินไป",
          text: "อัปโหลดได้สูงสุด 13 รูป",
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
          icon: "error",
        });
        return;
      }

      let loader = this.$loading.show();
      const Images = event.target.files;
      const formData = new FormData();
      this.$swal({
        title: "กำลังอัปโหลดรูป " + images.length + " รูป",
        text: "อย่าออกจากหน้านี้ ในขณะอัปโหลด",
        allowOutsideClick: false,
        showConfirmButton: false,
        icon: "info",
      });
      // this.$toast.warning("กำลังอัปโหลดรูป " + images.length + " รูป");
      let res = {};
      let imagePreview = [];
      // let imagesID = [];
      for (let i = 0; i < images.length; i++) {
        formData.append("image", Images[i]);
        res = await this.$store.dispatch("googleImage/store", formData);
        imagePreview.push(res.data.image);
        // imagesID.push(res.data.id);
        if (res.data.success) {
          this.$swal({
            title: "อัปโหลดไปแล้ว " + (i + 1) + "/" + images.length + " รูป",
            text: "อย่าออกจากหน้านี้ ในขณะอัปโหลด",
            allowOutsideClick: false,
            showConfirmButton: false,
            icon: "success",
          });
        } else {
          i = images.length;
          this.$swal({
            title: "คุณไม่มีสิทธิ์อัปโหลดส่วนนี้ ",
            allowOutsideClick: false,
            confirmButtonText: "รับทราบ",
            icon: "error",
          });
        }
      }
      loader.hide();
      this.$emit("emitImagesId", imagePreview);

      // เก่า
      // formData.append("image", this.image);
      // //console.log(formData);
      // const response = await this.$store.dispatch(
      //   "googleImage/store",
      //   formData
      // );
      // if (response.status == 200) {
      //   this.propUploadImange.imagePreview = response.data.src_name;
      //   this.$toast.success("อัปโหลดรูปสำเร็จ");
      //   //this.form.product_propImageId = response.data.id;
      //   this.$emit("emitImageId", response.data.id);
      //   loader.hide();
      // } else {
      //   this.$toast.error("อัปโหลดรูปไม่สำเร็จ เกิดข้อผิดพลาดบางอย่าง");
      //   loader.hide();
      // }
    },
    clickRemoveImage(imageId) {
      this.$emit("emitRemoveImage", imageId);
    },
  },
};
</script>