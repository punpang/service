<template>
  <div>
    <v-select
      v-model="menu_main_id"
      :rules="prop_rule_menu_main_id"
      :items="selectMains"
      item-text="title"
      item-value="id"
      outlined
      label="เมนูหลัก"
      @change="emitSelectMain()"
    ></v-select>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["prop_menu_main_id", "prop_rule_menu_main_id"],
  data() {
    return {
      menu_main_id: this.prop_menu_main_id,
    };
  },
  methods: {
    emitSelectMain() {
      this.$emit("emitSelectMain", this.menu_main_id);
    },
  },
  mounted() {
    this.$store.dispatch("menuBar/selectMain");
  },
  computed: {
    ...mapGetters({ selectMains: "menuBar/selectMain" }),
  },
};
</script>