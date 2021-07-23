<template>
  <div>
    <h4 class="font-weight-black mb-3">
      เลือกเซทบุฟเฟต์ <v-icon @click="ClickDetailPriceRange()">details</v-icon>
    </h4>

    <v-radio-group v-model="propFormPriceRange.priceRange_id" :rules="rules.priceRange">
      <v-radio
        v-for="priceRange in priceRanges"
        :key="priceRange.id"
        :label="
          priceRange.title +
          ' [' +
          priceRange.price_Children +
          'บ.|' +
          priceRange.price_Adult +
          'บ.]'
        "
        :value="priceRange.id"
        @click="clickPriceRange()"
      ></v-radio>
    </v-radio-group>
    <div v-show="ShowDetailPriceRange">
      <v-divider class="ma-0"></v-divider>
      <p
        class="caption mb-0"
        v-for="priceRange in priceRanges"
        :key="priceRange.id"
      >
        *{{ priceRange.title }} | เด็กเล็ก:{{ priceRange.price_Infant }}บ.
        ,เด็ก:{{ priceRange.price_Children }}บ. ,เด็กโต:{{
          priceRange.price_Adolescence
        }}บ. ,ผู้ใหญ่:{{ priceRange.price_Adult }}บ. ,ผู้สูงอายุ:{{
          priceRange.price_Elder
        }}บ.
      </p>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["propFormPriceRange"],
  data() {
    return {
      ShowDetailPriceRange: false,
      rules: {
        priceRange: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    clickPriceRange() {
      this.$emit("emitPriceRange", this.propFormPriceRange.priceRange_id);
    },
    ClickDetailPriceRange() {
      this.ShowDetailPriceRange = !this.ShowDetailPriceRange;
    },
  },
  async mounted() {
    await this.$store.dispatch("priceRange/all");
  },
  computed: {
    ...mapGetters({ priceRanges: "priceRange/all" }),
  },
};
</script>