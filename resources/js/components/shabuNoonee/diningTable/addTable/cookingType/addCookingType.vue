<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on">
          <v-icon>add</v-icon>
          เพิ่มเตา</v-btn
        >
      </template>
      <v-card>
        <v-card-title>
          <h4 class="mb-0">เพิ่มเตา</h4>
          <v-spacer></v-spacer>
          <v-btn fab icon x-small>
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider class="mt-0"></v-divider>

        <v-form ref="form" lazy-validation
          ><v-card-text>
            <v-select
              @change="changeCookingType(cookingType)"
              label="ประเภท"
              outlined
              v-model="form.cookingType"
              :items="cookingType"
              item-text="title"
              item-value="id"
              :rules="rules.cookingType"
              hide-details
            ></v-select>
            <v-checkbox
              v-if="form.cookingType === 1"
              hide-details
              v-for="broth in broths.product_use_only"
              :key="broth.id"
              :value="broth"
              :label="broth.title"
              v-model="form.broths"
              color="orange"
              :disabled="
                form.broths.length > 1 && form.broths.indexOf(broth) == -1
              "
            ></v-checkbox> </v-card-text
        ></v-form>

        <v-card-actions>
          <v-row>
            <v-col class="px-2">
              <v-btn color="success" x-large block @click="save()">
                <v-icon left>local_dining</v-icon>
                บันทึก</v-btn
              ></v-col
            >
            <v-col class="px-2">
              <v-btn color="error" x-large block>
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
import { mapGetters } from "vuex";
export default {
  props: ["propCookingType"],
  data() {
    return {
      dialog: false,
      form: {
        cookingType: "",
        cookingTypeTitle: "",
        broths: [],
      },
      rules: {
        cookingType: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    async changeCookingType(cookingTypeTitle) {
      if (this.form.cookingType === 1) {
        const res = await this.$store.dispatch("productGroup/broths");
      }

      for (let index = 0; index < cookingTypeTitle.length; index++) {
        if (cookingTypeTitle[index].id === this.form.cookingType) {
          this.form.cookingTypeTitle = cookingTypeTitle[index].title;
          return;
        }
      }
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.form.cookingType === 1) {
          if (this.form.broths.length === 0) {
            this.$toast.warning("โปรดเลือกน้ำซุปอย่างน้อย 1 รายการ");
            return;
          }
        }

        this.$emit("emitAddCookingType", this.form);
        this.reset();
        this.dialog = false;
      }
    },
    reset() {
      this.form = {
        cookingType: "",
        broths: [],
      };
    },
  },
  async mounted() {
    await this.$store.dispatch("cookingType/self");
  },
  computed: {
    ...mapGetters({ cookingType: "cookingType/self" }),
    ...mapGetters({ broths: "productGroup/broths" }),
  },
};
</script>