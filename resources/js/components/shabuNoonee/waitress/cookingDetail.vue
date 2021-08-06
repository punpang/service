<template>
  <div>
    <v-card class="mb-4">
      <v-card-title>
        <h1 class="mb-0 pt-2">
          <strong>{{
            self.table_dining_select_user_id.detail_table.name
          }}</strong>
        </h1>
      </v-card-title>
      <v-divider class="ma-0"></v-divider>
      <v-card-text>
        <v-simple-table>
          <tbody>
            <tr>
              <td>
                <h2 v-if="self.detail_cooking.count_of_dining_equipment > 0">
                  จานช้อน x
                  {{ self.detail_cooking.count_of_dining_equipment }} ชุด
                </h2>
                <h2 class="mb-1" v-if="self.detail_cooking.type_cooking">
                  {{ self.detail_cooking.type_cooking.title }}
                </h2>

                <h5
                  class="pl-6 mb-0 pt-3"
                  v-for="broth_detail in self.detail_cooking.broth_details"
                  :key="broth_detail.id"
                  v-if="self.detail_cooking.broth_details"
                >
                  x {{ broth_detail.product.title }}
                </h5>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card-text>
      <v-divider class="ma-0"></v-divider>
    </v-card>

    <v-btn block x-large color="error"> ยกเลิกรายการ </v-btn>

    <btnSave :propStatus="propStatus"></btnSave>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnSave from "@/js/components/shabuNoonee/waitress/btnSave";

export default {
  props: ["propStatus"],
  components: {
    btnSave,
  },
  computed: {
    ...mapGetters({ self: "WaitressQueueOrder/self" }),
  },
};
</script>