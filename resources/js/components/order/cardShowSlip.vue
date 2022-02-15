<template>
  <div>
    <v-dialog width="400" v-model="dialog" scrollable>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" x-small icon fab class="white--text" elevation="0">
          <v-icon>image</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-text class="pa-4">
          <v-img
            :src="
              'https://drive.google.com/thumbnail?id=' +
              propSrcName +
              '&sz=w800-h800'
            "
          ></v-img>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["propSrcName"],
  data() {
    return {
      dialog: false,
    };
  },
};
</script>