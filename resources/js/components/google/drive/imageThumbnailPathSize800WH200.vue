<template>
  <v-img
    :src="'https://drive.google.com/thumbnail?id=' + path + '&sz=w800-h800'"
    :lazy-src="
      'https://drive.google.com/thumbnail?id=' + path + '&sz=w800-h800'
    "
    max-height="200"
    max-width="200"
  >
    <template v-slot:placeholder>
      <v-row class="fill-height ma-0" align="center" justify="center">
        <v-progress-circular
          indeterminate
          color="grey lighten-5"
        ></v-progress-circular>
      </v-row>
    </template>
  </v-img>
</template>

<script>
export default {
  props: ["path"],
};
</script>

<style></style>
