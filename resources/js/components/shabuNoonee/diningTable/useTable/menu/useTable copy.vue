<template>
  <v-dialog v-model="dialog" persistent width="500">
    <template v-slot:activator="{ on }">
      <v-card v-on="on" color="green accent-3" @click="start()">
        <v-card-text class="white--text text-center">
          <h1 class="ma-4"></h1>
        </v-card-text>
      </v-card>
    </template>

    <v-card>
      <v-card-title class="pb-0">
        <h3 class="mb-0">ใช้งานอยู่ </h3>
        <v-spacer></v-spacer>
        <v-btn icon fab x-small @click="dialog = false">
          <v-icon color="error">close</v-icon>
        </v-btn>
      </v-card-title>
      <v-divider></v-divider>
      <v-card-text>
      </v-card-text>
      <v-card-actions>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
      dialog: false,
    };
  },
  methods: {

  },
  computed: {
  },
};
</script>