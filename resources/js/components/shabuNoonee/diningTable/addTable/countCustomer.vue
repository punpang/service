<template>
  <div>
    <h4 class="font-weight-black mb-4">จำนวนลูกค้า</h4>
    <v-row>
      <v-col>
        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">
              เด็กเล็ก :: {{ propformCount.count_Infant }} คน
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <v-btn outlined small @click="clickCutCount(1)">-</v-btn>
            <v-btn outlined small @click="clickAddCount(1)">+</v-btn>
          </v-col>
        </v-row>

        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">
              เด็กกลาง :: {{ propformCount.count_Children }} คน
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <v-btn outlined small @click="clickCutCount(2)">-</v-btn>
            <v-btn outlined small @click="clickAddCount(2)">+</v-btn>
          </v-col>
        </v-row>

        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">
              เด็กโต :: {{ propformCount.count_Adolescence }} คน
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <v-btn outlined small @click="clickCutCount(3)">-</v-btn>
            <v-btn outlined small @click="clickAddCount(3)">+</v-btn>
          </v-col>
        </v-row>

        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">
              ผู้ใหญ่ :: {{ propformCount.count_Adult }} คน
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <v-btn outlined small @click="clickCutCount(4)">-</v-btn>
            <v-btn outlined small @click="clickAddCount(4)">+</v-btn>
          </v-col>
        </v-row>

        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">
              ผู้สูงอายุ :: {{ propformCount.count_Elder }} คน
            </h5>
          </v-col>
          <v-col class="text-right mr-2 py-1">
            <v-btn outlined small @click="clickCutCount(5)">-</v-btn>
            <v-btn outlined small @click="clickAddCount(5)">+</v-btn>
          </v-col>
        </v-row>

        <v-divider></v-divider>
        <v-row>
          <v-col class="ml-2 py-1">
            <h5 class="mb-0 mt-1">รวม :: {{ sumCountCustomer() }} คน</h5>
          </v-col>
          <v-col class="text-right mr-2 py-1"> </v-col>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  props: ["propformCount"],
  data() {
    return {};
  },
  methods: {
    clickAddCount(v) {
      if (v === 1) {
        this.propformCount.count_Infant = ++this.propformCount.count_Infant;
      } else if (v === 2) {
        this.propformCount.count_Children = ++this.propformCount.count_Children;
      } else if (v === 3) {
        this.propformCount.count_Adolescence = ++this.propformCount
          .count_Adolescence;
      } else if (v === 4) {
        this.propformCount.count_Adult = ++this.propformCount.count_Adult;
      } else if (v === 5) {
        this.propformCount.count_Elder = ++this.propformCount.count_Elder;
      }
    },
    clickCutCount(v) {
      if (v === 1 && this.propformCount.count_Infant !== 0) {
        this.propformCount.count_Infant = --this.propformCount.count_Infant;
      } else if (v === 2 && this.propformCount.count_Children !== 0) {
        this.propformCount.count_Children = --this.propformCount.count_Children;
      } else if (v === 3 && this.propformCount.count_Adolescence !== 0) {
        this.propformCount.count_Adolescence = --this.propformCount
          .count_Adolescence;
      } else if (v === 4 && this.propformCount.count_Adult !== 0) {
        this.propformCount.count_Adult = --this.propformCount.count_Adult;
      } else if (v === 5 && this.propformCount.count_Elder !== 0) {
        this.propformCount.count_Elder = --this.propformCount.count_Elder;
      }
    },
    sumCountCustomer() {
      const sum =
        this.propformCount.count_Infant +
        this.propformCount.count_Children +
        this.propformCount.count_Adolescence +
        this.propformCount.count_Adult +
        this.propformCount.count_Elder;

      this.propformCount.sumCountCustomer = sum;
      return sum;
    },
  },
  async mounted() {},
  computed: {},
};
</script>