<template>
  <div>
    <h3>โปรโมชั่นวันนี้</h3>
    <hr />

    <v-card class="mx-auto mb-4" v-for="promotion in promotions" :key="promotion.id">
      <imageThumbnailPathSize800
        :path="promotion.image"
      ></imageThumbnailPathSize800>
      <v-card-title> {{ promotion.title }} </v-card-title>

      <v-card-subtitle> {{ promotion.content }} </v-card-subtitle>
      <v-card-subtitle> วันรับสินค้า {{ promotion.date_get }} </v-card-subtitle>
      <v-card-actions>
        <v-btn
          class="warning"
          x-large
          block
          v-if="promotion.status_use"
          :to="'promotion/' + promotion.id"
        >
          สนใจรายการนี้
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";

export default {
  components: {
    imageThumbnailPathSize800,
  },
  async mounted() {
    await this.$store.dispatch("promotion/fetchAll");
  },
  computed: {
    ...mapGetters({ promotions: "promotion/fetchAll" }),
  },
};
</script>