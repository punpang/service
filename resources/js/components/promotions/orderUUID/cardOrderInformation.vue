<template>
  <div v-if="propOrder.promotion">
    <v-card class="mb-4">
      <v-card-title>
        <h4 class="">รายละเอียด</h4>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6"> ชื่อแคมเปญ </v-col>
          <v-col cols="6" class="text-right">
            {{ propOrder.promotion.title }}
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6"> วันที่นัดรับสินค้า </v-col>
          <v-col cols="6" class="text-right">
            {{ propOrder.promotion.date_get }}
          </v-col>
        </v-row>
        <v-row v-if="propOrder.order_status_id >= 3">
          <v-col cols="6"> เวลานัดรับสินค้า </v-col>
          <v-col cols="6" class="text-right">
            {{ propOrder.time_get }}
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6"> วันเวลาที่สั่งซื้อ </v-col>
          <v-col cols="6" class="text-right">
            {{ propOrder.created_at }}
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["propOrder"],
};
</script>