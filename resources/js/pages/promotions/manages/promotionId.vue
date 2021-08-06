<template>
  <div>
    <v-card class="mb-4">
      <v-card-title>
        <h2 class="mb-0">DashBoard</h2>
        <v-spacer></v-spacer>
        <v-btn icon fab x-small @click="start()">
          <v-icon color="info">refresh</v-icon>
        </v-btn>
        <dialogDetail
          :propOrderStatus="fetchAllByID.order_status"
        ></dialogDetail>
      </v-card-title>
    </v-card>

    <v-card v-if="fetchAllByID.promotion" class="mb-4">
      <v-card-title>
        <h4 class="mb-0">รายละเอียด</h4>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" md="6">
            <v-row>
              <v-col cols="6"> <strong> ชื่อโปรโมชั่น</strong></v-col>
              <v-col cols="6" class="text-right">
                {{ fetchAllByID.promotion.title }}
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6"> <strong> วันที่รับสินค้า</strong></v-col>
              <v-col cols="6" class="text-right">
                {{ fetchAllByID.promotion.date_get }}
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12" md="6">
            <v-row>
              <v-col cols="6"> <strong> วันที่เริ่ม</strong></v-col>
              <v-col cols="6" class="text-right">
                {{ fetchAllByID.promotion.date_start }}
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6"> <strong> วันที่สิ้นสุด</strong></v-col>
              <v-col cols="6" class="text-right">
                {{ fetchAllByID.promotion.date_end }}
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <v-row class="mb-2">
      <v-col cols="12" md="6">
        <v-text-field
          v-model="search"
          outlined
          label="ค้นหาชื่อ/เบอร์โทร/เลขOR."
          placeholder="ค้นหาชื่อ/เบอร์โทร/เลขOR."
          @click="search = ''"
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-select
          label="สถานะสินค้า"
          outlined
          :items="fetchAllByID.order_status"
          item-text="title"
          item-value="id"
          v-model="status_on"
          hide-details
        ></v-select>
      </v-col>
    </v-row>

    <v-card
      v-if="status_on === parseInt(index)"
      v-for="(orders, index) in fetchAllByID.orders"
      :key="index"
      class="mb-4"
    >
      <v-card-title>
        <h4>{{ order_status_name(index) }} : ( {{ orders.length }} รายการ )</h4>
      </v-card-title>
      <v-card-text>
        <v-data-table
          :headers="headers"
          :items="orders"
          item-key="id"
          :search="search"
          hide-default-footer
        >
          <template v-slot:item.manages="{ item }">
            <cardManages :propOrder="item"></cardManages>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import cardManages from "@/js/components/promotions/manage/cardManages";
import dialogDetail from "@/js/components/promotions/manage/dialogDetail";
export default {
  components: {
    cardManages,
    dialogDetail,
  },
  data() {
    return {
      status_on: 1,
      search: "",
      headers: [
        {
          text: "#",
          value: "id",
        },
        {
          text: "ชื่อลูกค้า",
          value: "customer.name",
        },
        {
          text: "เบอร์โทร",
          value: "customer.phone_number",
        },
        {
          text: "เวลานัดรับสินค้า",
          value: "time_get",
        },
        {
          text: "การจัดการ",
          value: "manages",
        },
      ],
    };
  },
  methods: {
    countOrder(id) {
      return id;
    },
    order_status_name(key) {
      const status = this.fetchAllByID.order_status;

      for (let index = 0; index < status.length; index++) {
        if (status[index].id === parseInt(key)) {
          return status[index].title;
        }
      }
    },
    async start() {
      let loader = this.$loading.show();
      await this.$store.dispatch("promotion/fetchAllByID", {
        id: this.$route.params.id,
      });
      loader.hide();
    },
  },
  async mounted() {
    this.start();
    // await axios.get(`/api/${this.$route.params.id}/test`);
  },
  computed: {
    ...mapGetters({ fetchAllByID: "promotion/fetchAllByID" }),
  },
};
</script>

<style>
</style>