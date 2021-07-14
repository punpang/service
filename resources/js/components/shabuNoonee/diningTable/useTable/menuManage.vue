<template>
  <div>
    <v-menu offset-y>
      <template v-slot:activator="{ on }">
        <v-btn block color="primary" dark v-on="on">
          การจัดการ
        </v-btn>
      </template>
      <v-list>
        <v-list-item @click="start()">
          <v-list-item-title>รายการอาหาร</v-list-item-title>
        </v-list-item>
        <updateCountCustomer
          :table="table"
          
        ></updateCountCustomer>
        <v-list-item>
          <v-list-item-title>เปลี่ยนเซทบุฟเฟต์</v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>ชำระเงิน</v-list-item-title>
        </v-list-item>
        <v-list-item>
          <v-list-item-title>ย้ายโต๊ะ</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
import updateCountCustomer from "@/js/components/shabuNoonee/diningTable/useTable/menu/updateCountCustomer";
export default {
  props: ["table"],
  components: {
    updateCountCustomer,
  },
  data() {
    return {
      closeOnClick: false,
    };
  },
};
</script>