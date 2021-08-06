<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="info mb-2" dark block>
          <v-icon left>file_upload</v-icon>
          อัปโหลดสลิปที่นี่
        </v-btn>
      </template>

      <v-card>
        <v-card-title>
          <h3 class="mb-0">อัปโหลดสลิปชำระเงิน</h3>
          <v-spacer></v-spacer>
          <v-btn fab icon x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <cardCondition></cardCondition>
          <v-divider></v-divider>
          <v-form ref="formUploadSlip" lazy-validation>
            <cardUploadImage
              @emitSrcName="emitSrcName"
              :propUploadImange="uploadImange"
            ></cardUploadImage>
            <v-checkbox
              class="mt-0"
              v-model="accept"
              label="อ่านและยินยอมรับเงื่อนไขทั้งหมด"
            ></v-checkbox>
          </v-form>

          <v-btn
            class="success"
            large
            block
            :disabled="!accept"
            @click="save()"
          >
            <v-icon left>file_upload</v-icon>
            ส่งการชำระเงิน</v-btn
          >
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
import cardCondition from "@/js/components/promotions/orderUUID/cardCondition";
import cardUploadImage from "@/js/components/promotions/orderUUID/cardUploadImage";
import { mapGetters } from "vuex";

export default {
  components: {
    cardCondition,
    cardUploadImage,
  },

  data() {
    return {
      dialog: false,
      accept: false,
      uploadImange: {
        imagePreview: "",
        file: null,
      },
      src_name: "",
    };
  },
  methods: {
    emitSrcName(v) {
      this.src_name = v;
    },
    async save() {
      if (!this.accept) {
        this.$swal({
          title: "คำเตือน",
          text: "โปรดอ่านและยิมยอมเงื่อนไข",
          allowOutsideClick: false,
          confirmButtonText: "รับทราบ",
        });
      }
      if (this.$refs.formUploadSlip.validate()) {
        let loader = this.$loading.show();
        const form = {
          order: this.fetchByUUID,
          image_slip: this.src_name,
        };

        const res = await this.$store.dispatch("payment/store", form);

        if (res.status === 200) {
          this.$swal({
            title: res.data.msgTitle,
            text: res.data.msgText,
            icon: "success",
            allowOutsideClick: false,
            confirmButtonText: "รับทราบ",
          });
        } else if (res.status === 201) {
          this.$swal({
            title: res.data.msgTitle,
            text: res.data.msgText,
            icon: "warning",
            allowOutsideClick: false,
            confirmButtonText: "รับทราบ",
          });
        }
        await this.$store.dispatch(
          "order/fetchByUUID",
          this.$route.params.uuid
        );

        this.dialog = false;

        loader.hide();
      }
    },
  },
  computed: {
    ...mapGetters({ fetchByUUID: "order/fetchByUUID" }),
  },
};
</script>