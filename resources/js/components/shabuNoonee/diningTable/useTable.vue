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
      <v-card-title class="pb-0">
        <h3 class="mb-0">ใช้งานอยู่ : {{ dataTable.name }}</h3>
        <v-spacer></v-spacer>
        <v-btn icon fab x-small @click="dialog = false">
          <v-icon color="error">close</v-icon>
        </v-btn>
      </v-card-title>
      <v-divider></v-divider>
      <v-card-text>
        <v-row>
          <v-col cols="12" md="6">
            <mainCountCustmer :table="table"></mainCountCustmer>
          </v-col>
          <v-col cols="12" md="6">
            <mainSelectPriceRange :table="table"></mainSelectPriceRange>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions> </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import mainCountCustmer from "@/js/components/shabuNoonee/diningTable/useTable/menu/countCustmer/mainCountCustmer";
import mainSelectPriceRange from "@/js/components/shabuNoonee/diningTable/useTable/menu/selectPriceRange/mainSelectPriceRange";

import { mapGetters } from "vuex";

export default {
  props: ["dataTable"],
  components: {
    mainCountCustmer,
    mainSelectPriceRange,
  },
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    async start() {
      let loader = this.$loading.show();
      await this.$store.dispatch("diningTable/table", this.dataTable.table.id);
      loader.hide();
    },
  },
  computed: {
    ...mapGetters({ table: "diningTable/table" }),
  },
};
</script>