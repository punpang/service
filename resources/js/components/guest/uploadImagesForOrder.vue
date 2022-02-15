<template>
  <div>
    <v-dialog v-model="dialog" persistent width="350">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on">
          <!-- @click="save()" :disabled="!self.id" -->
          <span class="white--text"> อัปโหลดรูปภาพ </span>
          <v-icon class="white--text">file_upload</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          อัปโหลดรูปภาพ
          <v-spacer></v-spacer>
          <v-icon color="error" @click="exit">close</v-icon>
        </v-card-title>
        <v-card-text>
          <uploadImageMultiple
            :propUploadImange="propImages"
            @emitImagesId="emitImagesId"
            @emitRemoveImage="emitRemoveImage"
          ></uploadImageMultiple>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import uploadImageMultiple from "@/js/components/google/drive/uploadImageMultiple";

export default {
  props: ["propImages"],
  components: {
    uploadImageMultiple,
  },
  data() {
    return {
      dialog: false,
      uploadImange: { imagePreview: "", file: null },
    };
  },
  methods: {
    exit() {
      this.dialog = false;
    },
    start() {
      this.$emit("emitStart");
    },
    async emitImagesId(imagesData) {
      let loader = this.$loading.show();
      const data = {
        uuid: this.$route.params.uuid,
        imagesData: imagesData,
      };

      const res = this.$store.dispatch(
        "orderGuestUuid/uploadImagesByUUID",
        data
      );

      this.start();

      //   console.log(res);
      this.$swal({
        title: "อัปโหลดรูปทั้งหมดเรียบร้อย",
        allowOutsideClick: false,
        confirmButtonText: "รับทราบ",
        icon: "success",
      });

      loader.hide();
    },
    async emitRemoveImage(imageId) {
      let loader = this.$loading.show();
      const data = {
        uuid: this.$route.params.uuid,
        imageId: imageId,
      };
      const res = await this.$store.dispatch(
        "orderGuestUuid/removeImageIdByUUID",
        data
      );

      if (res.status == 200) {
        this.start();
        this.$swal({
          title: res.data.message,
          icon: "success",
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      } else {
        this.$swal({
          title: "เกิดข้อผิดพลาดบางอย่าง",
          icon: "error",
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      }

      loader.hide();
    },
  },
};
</script>