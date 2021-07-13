<template>
  <div>
    <v-row>
      <v-col cols="12" md="4" sm="4" v-for="table in allTable" :key="table.id">
        <addTable v-if="table.table === null" :dataTable="table"></addTable>
        <useTable
          v-else-if="table.table.status_id === 1"
          :dataTable="table"
        ></useTable>
        <paymentTable
          v-else-if="table.table.status_id === 2"
          :dataTable="table"
        ></paymentTable>
        <cleaningTable
          v-else-if="table.table.status_id === 3"
          :dataTable="table"
        ></cleaningTable>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import addTable from "@/js/components/shabuNoonee/diningTable/addTable";
import useTable from "@/js/components/shabuNoonee/diningTable/useTable";
import paymentTable from "@/js/components/shabuNoonee/diningTable/paymentTable";
import cleaningTable from "@/js/components/shabuNoonee/diningTable/cleaningTable";

import { mapGetters } from "vuex";
export default {
  components: {
    addTable,
    useTable,
    paymentTable,
    cleaningTable,
  },
  methods: {
    test() {
      this.$toast.success("Click Success");
    },
    colorTable(v) {
      if (v === null) {
        return "green accent-2 text--dark";
      } else {
        if (v.status_id === 1) {
          return "warning";
        }
      }
    },
  },
  async mounted() {
    await this.$store.dispatch("diningTable/allTable");
  },
  computed: {
    ...mapGetters({ allTable: "diningTable/allTable" }),
  },
};
</script>