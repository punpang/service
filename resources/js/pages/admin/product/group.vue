<template>
  <div>
    <tableGroupProduct></tableGroupProduct>

    <v-overlay :value="overlay">
      <v-progress-circular
        indeterminate
        :size="this.$store.getters['main/sizeOverlay']"
      ></v-progress-circular>
    </v-overlay>
  </div>
</template>

<script>
import tableGroupProduct from "@/js/components/shabuNoonee/products/groupProducts/table";
import { mapGetters } from "vuex";

export default {
  components: {
    tableGroupProduct,
  },
  data() {
    return {
      dialog: false,
      overlay: false,
    };
  },
  async mounted() {
    this.overlay = true;
    const res = await this.$store.dispatch("productGroup/all");
    if (res.status === 200) {
      this.$toast.success(res.data.message);
    } else {
      this.$toast.error("โหลดข้อมูลไม่สำเร็จ");
    }
    this.overlay = false;
  },
  computed: {
    ...mapGetters({ all: "productGroup/all" }),
  },
};
</script>