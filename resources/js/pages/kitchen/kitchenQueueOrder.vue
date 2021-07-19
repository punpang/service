<template>
  <div>
    <v-card>
      <v-card-title>
        <h3># {{ self.id }}</h3>
        <v-spacer></v-spacer>
        <h5>จำนวน {{ sumQuantity }} ถาด</h5>
      </v-card-title>
      <v-card-subtitle>
        <h5>ใช้เวลาไป : {{ countDown }} วินาที</h5>
      </v-card-subtitle>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      countDown: 0,
    };
  },
  methods: {
    countDownTimer() {
      setTimeout(() => {
        this.countDown -= 1;
        this.countDownTimer();
      }, 1000);
      console.log(this.countDown);
    },
  },
  async mounted() {
    await this.$store.dispatch("kitchenQueueOrder/self");
    this.countDown = 100;
  },
  computed: {
    ...mapGetters({ self: "kitchenQueueOrder/self" }),
    ...mapGetters({ sumQuantity: "kitchenQueueOrder/sumQuantity" }),
  },
};
</script>