<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <v-card v-on="on" color="green accent-3" @click="start()">
          <v-card-text class="white--text text-center">
            <h3 class="ma-3">จัดการเตา</h3>
          </v-card-text>
        </v-card>
      </template>

      <v-card>
        <v-card-title>
          <h3 class="mb-0">จัดการเตา</h3>
          <addCookingType
            class="ml-2"
            @emitAddCookingType="emitAddCookingType"
          ></addCookingType>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <!-- <v-divider class="mt-0"></v-divider> -->
        <v-card-text>
          <tableCookingType :propCookingType="self"></tableCookingType>
          <!-- <formCookingType :propFormCookingType="form"></formCookingType> -->
        </v-card-text>
        <!-- <v-card-actions>
          <v-row>
            <v-col class="px-2">
              <v-btn color="success" x-large block @click="save()">
                <v-icon left>local_dining</v-icon>
                เพิ่มเตา</v-btn
              ></v-col
            >
            <v-col class="px-2">
              <v-btn color="error" x-large block>
                <v-icon left>exit_to_app</v-icon>
                ออก</v-btn
              ></v-col
            >
          </v-row></v-card-actions
        > -->
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import addCookingType from "@/js/components/shabuNoonee/diningTable/addTable/cookingType/addCookingType";
import formCookingType from "@/js/components/shabuNoonee/diningTable/addTable/cookingType/_formCookingType";
import tableCookingType from "@/js/components/shabuNoonee/diningTable/addTable/cookingType/_tableCookingType";

import { mapGetters } from "vuex";

export default {
  props: ["table"],
  components: {
    addCookingType,
    formCookingType,
    tableCookingType,
  },
  data() {
    return {
      dialog: false,
      form: {
        cookingType: "",
        cookingTypeTitle: "",
        broths: [],
      },
    };
  },
  methods: {
    async emitAddCookingType(v) {
      let loader = this.$loading.show();

      const form = {
        data: v,
        dining_table_id: this.table.id,
      };
      const res = await this.$store.dispatch("cookingDetail/store", form);

      if (res.status === 200) {
      } else if (res.status === 201) {
        this.$toast.warning(res.data.msg);
      } else {
        this.$toast.error("โปรดลองอีกครั้ง");
      }
      loader.hide();

      this.start();
    },
    async start() {
      let loader = this.$loading.show();
      await this.$store.dispatch("cookingDetail/self", this.table.id);
      loader.hide();
    },
  },
  computed: {
    ...mapGetters({ self: "cookingDetail/self" }),
  },
};
</script>