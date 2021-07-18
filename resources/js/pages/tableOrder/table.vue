<template>
  <div>
    <emptyTableOrder v-if="self === null">โต๊ะว่าง</emptyTableOrder>
    <useTableOrder v-else-if="self.status_id === 1"></useTableOrder>
    <div v-else-if="self.status_id === 2">สถานะ 2 :: ชำระเงิน</div>
    <div v-else-if="self.status_id === 3">สถานะ 3 :: กำลังทำความสะอาด</div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import useTableOrder from "@/js/components/shabuNoonee/tableOrder/useTableOrder";
import emptyTableOrder from "@/js/components/shabuNoonee/tableOrder/emptyTableOrder";
//import qrCode from 'vue-qrcode-component'

export default {
  components: {
    useTableOrder,
    emptyTableOrder,
  },
  data() {
    return {};
  },
  methods: {},
  async mounted() {
    let loader = this.$loading.show();
    await this.$store.dispatch("tableOrder/self");
    loader.hide();

    window.Echo.channel("DiningTableStatusOn").listen(
      ".DiningTableStatusAs",
      (e) => {
        if (this.tableUser.id === e.task.user_id) {
          this.$store.dispatch("tableOrder/self");
        }
      }
    );
  },
  computed: {
    ...mapGetters({ self: "tableOrder/self" }),
    ...mapGetters({ tableUser: "main/User" }),
  },
};
</script>