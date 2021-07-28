<template>
  <div>
    <v-card>
      <v-card-title>
        <h3># {{ self.id }}</h3>
      </v-card-title>
      <v-divider class="ma-0"></v-divider>
      <v-card-text>
        <v-simple-table>
          <tbody>
            <tr>
              <td>
                <h2
                  class="mt-2"
                  v-if="self.detail_cooking.count_of_dining_equipment > 0"
                >
                  จานช้อน x
                  {{ self.detail_cooking.count_of_dining_equipment }} ชุด
                </h2>
                <h2 class="mt-3 mb-3" v-if="self.detail_cooking.type_cooking">
                  {{ self.detail_cooking.type_cooking.title }}
                </h2>

                <h5
                  class="pl-4"
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