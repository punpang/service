<template>
  <div>
    <v-card class="mb-4">
      <v-card-title>
        <h3>ห้องครัว</h3>
        <v-spacer></v-spacer>
        <v-switch inset v-model="status" @click="start()"></v-switch>
      </v-card-title>
    </v-card>

    <nextToWaitress :propStatus="status"></nextToWaitress>
  </div>
</template>

<script>
import nextToWaitress from "@/js/components/shabuNoonee/kitchen/queueOrder/nextToWaitress";
import { mapGetters } from "vuex";

export default {
  components: {
    nextToWaitress,
  },
  data() {
    return {
      status: false,
    };
  },
  methods: {
    async start() {
      if (this.status) {
        await this.$store.dispatch("kitchenQueueOrder/self");
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
    window.Echo.channel("KitchenQueueOrderFetchOn").listen(
      ".KitchenQueueOrderFetchAs",
      (e) => {
        if (this.status === true && !this.self.id) {
          this.playSound();
          this.start();
        }
      }
    );
  },
  computed: {
    ...mapGetters({ self: "kitchenQueueOrder/self" }),
  },
};
</script>