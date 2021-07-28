<template>
  <v-form ref="form" lazy-validation>
    <v-select
      v-if="cookingType.length > 0"
      @change="changeCookingType(cookingType)"
      label="ประเภท"
      outlined
      v-model="propFormCookingType.cookingType"
      :items="cookingType"
      item-text="title"
      item-value="id"
      :rules="rules.cookingType"
      hide-details
    ></v-select>

    <v-checkbox
      v-if="propFormCookingType.cookingType === 1"
      hide-details
      v-for="broth in broths.product_use_only"
      :key="broth.id"
      :value="broth"
      :label="broth.title"
      v-model="propFormCookingType.broths"
      color="orange"
      :disabled="
        propFormCookingType.broths.length > 1 &&
        propFormCookingType.broths.indexOf(broth) == -1
      "
    ></v-checkbox>
  </v-form>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["propFormCookingType"],
  data() {
    return {
      dialog: false,
      rules: {
        cookingType: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    async changeCookingType(cookingTypeTitle) {
      if (this.propFormCookingType.cookingType === 1) {
        const res = await this.$store.dispatch("productGroup/broths");
      } else {
        this.propFormCookingType.broths = [];
      }

      for (let index = 0; index < cookingTypeTitle.length; index++) {
        if (
          cookingTypeTitle[index].id === this.propFormCookingType.cookingType
        ) {
          this.propFormCookingType.cookingTypeTitle =
            cookingTypeTitle[index].title;
          return;
        }
      }
    },
    save() {
      if (this.$refs.propFormCookingType.validate()) {
        if (this.propFormCookingType.cookingType === 1) {
          if (this.propFormCookingType.broths.length === 0) {
            this.$toast.warning("โปรดเลือกน้ำซุปอย่างน้อย 1 รายการ");
            return;
          }
        }

        this.$emit("emitAddCookingType", this.propFormCookingType);
        this.reset();
        this.dialog = false;
      }
    },
    exit() {
      this.dialog = false;
      this.reset();
    },
    reset() {
      this.propFormCookingType = {
        cookingType: "",
        cookingTypeTitle: "",
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