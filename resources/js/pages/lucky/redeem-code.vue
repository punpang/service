<template>
  <div>
    <v-card>
      <v-card-title> <h3>
        แลกรางวัล (REDEEM CODE)</h3> </v-card-title>
      <v-card-text>
        
        <!-- //// -->
        <v-row justify="center">
          <v-col md="5">
            <v-text-field
              label="เบอร์โทรลูกค้า"
              prepend-icon="phone"
              outlined
              v-model="datas.customers.phone"
              hide-details
            ></v-text-field>
          </v-col>
        </v-row>
        <!-- /// -->
        <v-row justify="center">
          <v-col md="5">
            <v-text-field
              label="Redeem Code"
              prepend-icon="redeem"
              outlined
              v-model="datas.customers.name"
              hide-details
            ></v-text-field>
          </v-col>
        </v-row>
        <!-- //// -->
        <v-row justify="center">
          <v-col md="5" class="pb-0">
            <v-btn class="success" block large>
                ตรวจสอบข้อมูล
            </v-btn>
          </v-col>
        </v-row>
        <!-- //// -->
        <v-row justify="center">
          <v-col md="5">
            <v-btn class="error" block large>
                ล้างข้อมูล
            </v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      datas: {
        number_of_right: 0,
        customers: {
          name: "",
          phone: "",
        },
      },

      nors: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], //number of rights
    };
  },
};
</script>