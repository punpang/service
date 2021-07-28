<template>
  <div>
    <v-card class="mb-4">
      <v-card-title>
        <h3>เสิร์ฟ</h3>
        <v-spacer></v-spacer>
        <v-switch inset v-model="status" @click="start()"></v-switch>
      </v-card-title>
    </v-card>

    <finished v-if="self.format_id === 1" :propStatus="status"></finished>

    <cookingDetail v-else-if="self.format_id === 2" :propStatus="status"></cookingDetail>

    <v-alert dense type="info" v-else>
      <strong>ยังไม่มีรายการอาหาร</strong>
    </v-alert>
  </div>
</template>

<script>
import finished from "@/js/components/shabuNoonee/waitress/finished";
import cookingDetail from "@/js/components/shabuNoonee/waitress/cookingDetail";

import { mapGetters } from "vuex";

export default {
  components: {
    finished,
    cookingDetail,
  },
  data() {
    return {
      status: false,
    };
  },
  methods: {
    async start() {
      if (this.status) {
        this.$store.dispatch("WaitressQueueOrder/self");
      }
    },
    async playSound() {
      const soundurl =
        "https://soundbible.com/mp3/Fire_pager-jason-1283464858.mp3";
      var audio = new Audio(soundurl);
      await audio.play();
    },
  },
  mounted() {
    window.Echo.channel("WaitressQueueOrderProcessingOn").listen(
      ".WaitressQueueOrderProcessingAs",
      (e) => {
        if (this.status && !this.self.id) {
          this.playSound();
          this.start();
        }
      }
    );
  },
  computed: {
    ...mapGetters({ self: "WaitressQueueOrder/self" }),
  },
};
</script>