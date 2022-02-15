<template>
  <div>
    <v-dialog width="500" v-model="dialog" scrollable>
      <template v-slot:activator="{ on }">
        <v-btn class="mb-2 amber lighten-1" v-on="on">
          <v-icon left>format_list_bulleted</v-icon>
          <strong>วิธีใช้งาน</strong>
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="grey lighten-2">
          วิธีใช้งาน QR CODE พร้อมเพย์
          <v-spacer></v-spacer>
          <v-btn icon fab small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="p-0">
          <v-card
            class="mb-3"
            outlined
            v-for="(image, i) in promptpay.images"
            :key="image"
          >
            <v-card-title class="grey lighten-2">
              ขั้นตอนที่ {{ i + 1 }}
            </v-card-title>
            <v-img
              :src="
                'https://drive.google.com/thumbnail?id=' +
                image +
                '&sz=w800-h800'
              "
            ></v-img>
          </v-card>
          <!-- <v-img
            v-for="image in promptpay.images"
            :key="image"
            :src="
              'https://drive.google.com/thumbnail?id=' + image + '&sz=w800-h800'
            "
          ></v-img> -->
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      promptpay: {
        images: [
          "1x-ueq2EN0Hn3fFZMViVTZwNFelgJ5ZYr",
          "10fk8X0EyvHaP52X4ewDNDj6K2uftKlB9",
          "1plrwjdapdCfzDzw3tr85NNjtFYPHgQQw",
          "1FR4Da58Wsnvj6nl9snEHDbYDteB6F92f",
          "1VEjeyFnIrESFjkrBHlqghTlOg8YRcSvo",
          "1wIK6gy_KOZ5t3pBG_wDvl4y7ow_vq2ah",
          "1Cg96LurZ6X6V6MVnuNicC6D0B82EMmhR",
          "1pS6AOhKWn2jzpEDPgSMdume9fNu1vJil",
        ],
      },
    };
  },
};
</script>