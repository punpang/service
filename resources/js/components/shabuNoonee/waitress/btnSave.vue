<template>
  <div>
    <v-bottom-navigation app class="yellow darken-4" grow>
      <v-btn block @click="save()" :disabled="!self.id">
        <span class="white--text"> ต่อไป </span>
        <v-icon class="white--text">arrow_forward_ios</v-icon>
      </v-btn>
    </v-bottom-navigation>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["propStatus"],
  methods: {
    async save() {
      const res = await this.$store.dispatch(
        "WaitressQueueOrder/finished",
        this.self.id
      );

      if (res.status === 200) {
        this.$swal({
          icon: "success",
          confirmButtonColor: "#3085d6",
          title: res.data.message,
          text: res.data.messageText,
          confirmButtonText: "รายการถัดไป",
          allowOutsideClick: false,
        });
      } else if (res.status === 201) {
        this.$swal({
          icon: "warning",
          confirmButtonColor: "#3085d6",
          title: res.data.message,
          confirmButtonText: "รายการถัดไป",
          allowOutsideClick: false,
        });
      }

      if (this.propStatus) {
        await this.$store.dispatch("WaitressQueueOrder/self");
      }
    },
  },
  computed: {
    ...mapGetters({ self: "WaitressQueueOrder/self" }),
  },
};
</script>