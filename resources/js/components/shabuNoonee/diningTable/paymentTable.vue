<template>
  <v-dialog v-model="dialog" persistent width="500">
    <template v-slot:activator="{ on }">
      <v-card v-on="on" color="green accent-3" @click="start()">
        <v-card-text class="white--text text-center">
          <h1 class="ma-4">{{ dataTable.name }}</h1>
        </v-card-text>
      </v-card>
    </template>
    <v-card>
      <v-card-title>
        <h3>
          {{ dataTable.name }} :: {{ dataTable.table.dining_table_status.title }}
        </h3>
        <v-spacer></v-spacer>
        <v-btn icon fab x-small @click="dialog = false">
          <v-icon color="error">close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        {{ dataTable }}
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["dataTable"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    start() {},
  },
};
</script>