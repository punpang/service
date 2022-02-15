<template>
  <div>
    <v-dialog
      width="300"
      transition="dialog-top-transition"
      scrollable
      v-model="dialog"
    >
      <template v-slot:activator="{ on }">
        <v-btn
          v-on="on"
          @click="start()"
          :block="propBlock"
          :large="propLarge"
          dark
          color="#003D6B"
        >
          <!-- <v-icon left>flip</v-icon> -->
          <strong>สร้าง QR CODE</strong>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h6 white--text warning">
          <strong>QR CODE</strong>

          <v-spacer></v-spacer>
          <v-btn icon fab x-small class="white" @click="exit">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="text-center">
          <qr-code class="mt-4" :text="propTextQRCODE" error-level="L">
          </qr-code>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import VueQRCodeComponent from "vue-qrcode-component";
Vue.component("qr-code", VueQRCodeComponent);
export default {
  props: ["propTextQRCODE", "propBlock", "propLarge", "propAmount"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    start() {
      let loader = this.$loading.show();      
      this.$emit("emitQrcode");
      loader.hide();
    },
    exit() {
      this.dialog = false;
    },
  },
};
</script>