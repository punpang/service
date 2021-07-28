<template>
  <div>
    <v-card v-if="self.id">
      <v-card-title>
        <h3># {{ self.id }}</h3>
        <v-spacer></v-spacer>
        <h5>ทั้งหมด {{ sumQuantity }} ถาด</h5>
      </v-card-title>
      <v-divider class="ma-0"></v-divider>
      <v-card-text>
        <v-simple-table>
          <tbody>
            <tr
              v-for="table_order_detail in self.table_order_details"
              :key="table_order_detail.id"
            >
              <td>
                <h2 class="mt-2">{{ table_order_detail.product.title }}</h2>
              </td>
              <td class="text-right">
                <h2 class="mt-2">{{ table_order_detail.quantity }}</h2>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card-text>
      <v-divider class="ma-0"></v-divider>
    </v-card>

    <v-alert dense type="info" v-else>
      <strong>ยังไม่มีรายการอาหาร</strong>
    </v-alert>

    <btnSave :propStatus="propStatus"></btnSave>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnSave from "@/js/components/shabuNoonee/waitress/btnSave";

export default {
  props: ["propStatus"],
  components: {
    btnSave,
  },
  data() {
    return {
      countUp: 1,
    };
  },
  methods: {
    // countUpTimer() {
    //   setTimeout(() => {
    //     this.countUp += 1;
    //     this.countUpTimer();
    //   }, 1000);
    // },
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
  async mounted() {
    //this.countUpTimer();
  },
  computed: {
    ...mapGetters({ self: "WaitressQueueOrder/self" }),
    ...mapGetters({ sumQuantity: "WaitressQueueOrder/sumQuantity" }),
  },
};
</script>