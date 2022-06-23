<template>
  <div v-if="propCustomer">
    <v-card class="mb-4">
      <v-card-title>
        <h4 class="">ข้อมูลลูกค้า</h4>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6"> ชื่อลูกค้า </v-col>
          <v-col cols="6" class="text-right">{{ propCustomer.name }}</v-col>
        </v-row>
        <v-row>
          <v-col cols="6"> เบอร์โทรศัพท์ </v-col>
          <v-col cols="6" class="text-right">
            {{ propCustomer.phone_number }}
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["propCustomer"],
};
</script>