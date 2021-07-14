<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <v-list-item v-on="on">
          <v-list-item-title>แก้ไขจำนวนคน</v-list-item-title>
        </v-list-item>
      </template>
      <v-card>
        <v-card-title class="pb-0">
          <h3 class="mb-0">แก้ไขจำนวนคน : {{ table.detail_table.name }}</h3>

          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <countCustomer :propformCount="table"></countCustomer>
        </v-card-text>
        <v-card-actions>
          <v-row>
            <v-col class="px-2">
              <v-btn color="success" x-large block @click="save()">
                <v-icon left>local_dining</v-icon>
                บันทึก</v-btn
              ></v-col
            >
            <v-col class="px-2">
              <v-btn color="error" x-large block @click="exit()">
                <v-icon left>exit_to_app</v-icon>
                ออก</v-btn
              ></v-col
            >
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import countCustomer from "@/js/components/shabuNoonee/diningTable/addTable/countCustomer";

export default {
  components: {
    countCustomer,
  },
  props: ["table"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    save() {},
    async exit() {
      await this.$store.dispatch("diningTable/table", this.table.id);
      this.dialog = false;
    },
  },
};
</script>