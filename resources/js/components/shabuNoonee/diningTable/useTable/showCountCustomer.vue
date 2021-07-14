<template>
  <div>
    <h4 class="font-weight-black mb-4">จำนวนลูกค้า</h4>
    <v-row>
      <v-col>
        <v-row v-if="table.count_Infant > 0">
          <v-col class="ml-2 py-1" cols="8">
            <h5 class="mb-0 mt-1">เด็กเล็ก ( {{ table.price_Infant }} บาท )</h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <h5 class="mb-0 mt-1">{{ table.count_Infant }} คน</h5></v-col
          >
        </v-row>

        <v-row v-if="table.count_Children > 0">
          <v-col class="ml-2 py-1" cols="8">
            <h5 class="mb-0 mt-1">เด็ก ( {{ table.price_Children }} บาท )</h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <h5 class="mb-0 mt-1">{{ table.count_Children }} คน</h5></v-col
          >
        </v-row>

        <v-row v-if="table.count_Adolescence > 0">
          <v-col class="ml-2 py-1" cols="8">
            <h5 class="mb-0 mt-1">
              เด็กโต ( {{ table.price_Adolescence }} บาท )
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <h5 class="mb-0 mt-1">{{ table.count_Adolescence }} คน</h5>
          </v-col>
        </v-row>

        <v-row v-if="table.count_Adult > 0">
          <v-col class="ml-2 py-1" cols="8">
            <h5 class="mb-0 mt-1">ผู้ใหญ่ ( {{ table.price_Adult }} บาท )</h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <h5 class="mb-0 mt-1">{{ table.count_Adult }} คน</h5></v-col
          >
        </v-row>

        <v-row v-if="table.count_Elder > 0">
          <v-col class="ml-2 py-1" cols="8">
            <h5 class="mb-0 mt-1">
              ผู้สูงอายุ ( {{ table.price_Elder }} บาท )
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <h5 class="mb-0 mt-1">{{ table.count_Elder }} คน</h5>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="ml-2 py-1" cols="8">
            <h5 class="mb-0 mt-1">รวม ( {{ table.sumPrice }} บาท )</h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <h5 class="mb-0 mt-1">{{ table.sum_customer }} คน</h5>
          </v-col>
        </v-row>
            <v-divider></v-divider>
        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">เซทบุฟเฟต์ : {{ table.price_range.title }}</h5>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  props: ["table"],
};
</script>