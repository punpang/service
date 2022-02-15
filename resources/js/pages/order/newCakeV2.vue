<template>
  <div>
    <v-form ref="form" lazy-validation>
      <v-row>
        <v-col cols="12" md="8">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ขนาด</h3>
            </v-card-title>
            <v-card-text>
              <v-radio-group row v-model="data[0]" :rules="rules.nofree">
                <v-radio
                  v-for="size in getSize"
                  :key="size.id"
                  :label="`${size.title} +฿${size.price_special}`"
                  :value="size.id"
                  @click="clickSize(size)"
                ></v-radio>
              </v-radio-group>
            </v-card-text>
          </v-card>

          <v-card class="mb-4">
            <v-card-title>
              <h3>เนื้อเค้ก</h3>
            </v-card-title>
            <v-card-text>
              <v-radio-group
                row
                v-model="data[1]"
                v-if="data[0]"
                :rules="rules.nofree"
              >
                <v-radio
                  v-for="CakeTexture in getCakeTexture"
                  :key="CakeTexture.id"
                  :label="`${CakeTexture.title} +฿${CakeTexture.price_special}`"
                  :value="CakeTexture.id"
                  @click="clickCakeTexture(CakeTexture)"
                ></v-radio>
              </v-radio-group>
              <v-alert type="error" v-else>โปรดเลือกขนาดก่อน</v-alert>
            </v-card-text>
          </v-card>

          <v-card class="mb-4">
            <v-card-title>
              <h3>รูปแบบ</h3>
            </v-card-title>
            <v-card-text>
              <v-radio-group
                row
                v-model="data[2]"
                v-if="data[1]"
                :rules="rules.nofree"
              >
                <v-radio
                  v-for="format in getFormat"
                  :key="format.id"
                  :label="`${format.title} +฿${format.price_special}`"
                  :value="format.id"
                  @click="clickFormat(format)"
                ></v-radio>
              </v-radio-group>
              <v-alert type="error" v-else>โปรดเลือกเนื้อเค้กก่อน</v-alert>
            </v-card-text>
          </v-card>
        </v-col>
        <!-- ////// -->
        <v-col cols="12" md="4">
          <v-card v-if="showSumTotal" class="mb-4">
            <v-card-title>
              <h3 class="mb-0">รวมราคา</h3>
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="6" md="6">ราคาสินค้า</v-col>
                <v-col cols="6" md="6" class="text-right">
                  {{ sumMainTotal | formatNumber }}
                </v-col>
                <!-- //// -->
                <v-col cols="6" md="6">ราคาตกแต่ง</v-col>
                <v-col cols="6" md="6" class="text-right">
                  {{ sumSubTotal | formatNumber }}
                </v-col>
                <!-- //// -->
                <v-col cols="6" md="6">รวมราคา</v-col>
                <v-col cols="6" md="6" class="text-right">
                  {{ sumTotal | formatNumber }}
                </v-col>
                <!-- //// -->
              </v-row>
            </v-card-text>
          </v-card>
          <v-alert v-else type="warning">โปรดเลือกรายการให้ครบ</v-alert>
          <v-row v-if="showSumTotal">
            <v-col
              cols="12"
              md="12"
              v-for="data in getCategorySub"
              :key="data.id"
            >
              <v-card>
                <v-card-title>
                  <h3>
                    {{ data.title }}
                  </h3>
                  <v-spacer></v-spacer>
                  <v-switch
                    inset
                    v-model="data.switch"
                    @click="switchDifferent(data.switchClose)"
                  ></v-switch>
                </v-card-title>
                <v-card-text v-if="data.switch">
                  <v-radio-group v-if="data.limit == 1">
                    <v-radio
                      v-for="v in dataCategorySub(data.id)"
                      :key="v.id"
                      :value="v.id"
                      @click="sadafgas(v, data.id)"
                      :label="`${v.category_sub_datail.title} +฿${v.price}`"
                    ></v-radio>
                  </v-radio-group>
                  <!-- <v-checkbox
                    v-else
                    v-for="v in sahdnop(data.id)"
                    :key="v.id"
                    :value="v.id"
                    @click="sadafgas(v, data.id)"
                    :label="`${v.category_sub_datail.title} +฿${v.price}`"
                  ></v-checkbox> -->
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-form>

    <!-- <v-row>
        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ขอบบน</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[0]"
                @click="swtest([3, 9, 10, 11])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ขอบข้าง</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[1]"
                @click="swtest([])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ตรงกลาง</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[2]"
                @click="swtest([3, 8, 9, 10, 11])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ครึ่งหน้า</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[3]"
                @click="swtest([0, 2, 8, 9, 10, 11])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สีครีม</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[4]"
                @click="swtest([5, 6])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สีครีมด้านบน</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[5]"
                @click="swtest([4])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สีครีมด้านข้าง</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[6]"
                @click="swtest([4])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สอดไส้</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[7]"
                @click="swtest([])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>รูปภาพ</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[8]"
                @click="swtest([2, 3, 9, 10, 11])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>โมเดล</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[9]"
                @click="swtest([0, 2, 3, 8, 10, 11])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>มินิมอล</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[10]"
                @click="swtest([0, 2, 3, 8, 9, 11])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ป๊อปอัป</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switchOn[11]"
                @click="swtest([0, 2, 3, 8, 9, 10])"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="3"></v-col>
        <v-col cols="12" md="3"></v-col>
      </v-row> -->

    <!-- <v-row>
        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>SwitchTest</h3>
              <v-spacer></v-spacer>
              <v-switch inset @click="swtest([0])"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ขอบบน</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switch1"
                @click="switch4 = false"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ขอบข้าง</h3>
              <v-spacer></v-spacer>
              <v-switch inset v-model="switch2"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ตรงกลาง</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switch3"
                @click="switch4 = false"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ครึ่งหน้า</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switch4"
                @click="(switch1 = false), (switch3 = false)"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สีครีม</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switch5"
                @click="(switch6 = false), (switch7 = false)"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สีครีมด้านบน</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switch6"
                @click="switch5 = false"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สีครีมด้านข้าง</h3>
              <v-spacer></v-spacer>
              <v-switch
                inset
                v-model="switch7"
                @click="switch5 = false"
              ></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>สอดไส้</h3>
              <v-spacer></v-spacer>
              <v-switch inset v-model="switch8"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>รูปภาพ</h3>
              <v-spacer></v-spacer>
              <v-switch inset v-model="switch9"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>โมเดล</h3>
              <v-spacer></v-spacer>
              <v-switch inset v-model="switch10"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>มินิมอล</h3>
              <v-spacer></v-spacer>
              <v-switch inset v-model="switch11"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>
              <h3>ป๊อปอัป</h3>
              <v-spacer></v-spacer>
              <v-switch inset v-model="switch12"></v-switch>
            </v-card-title>
            <v-card-text> </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="3"></v-col>
        <v-col cols="12" md="3"></v-col>
      </v-row> -->
  </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      dhfiseojf: [],
      switchOnTest: [],
      data: [],
      data2: [],
      datatest: [
        {
          id: 1,
          title: "ขอบบน",
          status_use: 1,
          switch: false,
          limit: 1,
          switchClose: [2],
        },
        {
          id: 2,
          title: "ครึ่งหน้า",
          status_use: 1,
          switch: false,
          limit: 1,
          switchClose: [1, 3],
        },
        {
          id: 3,
          title: "ตรงกลาง",
          status_use: 1,
          switch: false,
          limit: 1,
          switchClose: [2],
        },
      ],
      rules: {
        nofree: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
      switchOn: [
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
      ],
      switch1: false,
      switch2: false,
      switch3: false,
      switch4: false,
      switch5: false,
      switch6: false,
      switch7: false,
      switch8: false,
      switch9: false,
      switch10: false,
      switch11: false,
      switch12: false,
    };
  },
  methods: {
    sadafgas(v, d) {
      this.sdghnsakdi(d);
      this.dhfiseojf.push(v);
      // this.dhfiseojf.push({
      //   category_sub_id: d,
      //   category_sub_relationships_id: v.id,
      //   price:v.price
      // });
    },
    removeSame(d) {
      // ตัดที่หมวดเดียวกันออก
      this.dhfiseojf = this.dhfiseojf.filter(
        (e) => e.category_sub_datail.category_sub_id != d
      );
    },
    switchDifferent(v) {
      const value = v.split(", ");
      console.log(value[0]);
      for (let i = 0; i < value.length; i++) {
        let res = this.getCategorySub.find((e) => e.id == parseInt(value[i]));
        this.removeSame(parseInt(value[i]));
        res.switch = false;
      }
    },
    dataCategorySub(v) {
      const data = [
        {
          id: 1,
          category_datail_id: 1, // ขนาด
          category_sub_datail_id: 1, // kory
          status_use: 1,
          price: 50,
          category_sub_datail: {
            id: 1,
            title: "kory",
            category_sub_id: 1, // ขอบข้าง
            status_use: 1,
          },
        },
        {
          id: 2,
          category_datail_id: 1,
          category_sub_datail_id: 2,
          status_use: 1,
          price: 30,
          category_sub_datail: {
            id: 2,
            title: "KK",
            category_sub_id: 3,
            status_use: 1,
          },
        },
        {
          id: 3,
          category_datail_id: 1, // ขนาด
          category_sub_datail_id: 3, // KORY
          status_use: 1,
          price: 50,
          category_sub_datail: {
            id: 3,
            title: "OO",
            category_sub_id: 1,
            status_use: 1,
          },
        },
      ];

      const result = data.filter((e) => {
        return e.category_sub_datail.category_sub_id == v;
      });
      return result;
    },
    save() {
      if (this.$refs.form.validate()) {
        console.log("pass");
      }
    },

    swtest2(value) {
      for (let i = 0; i < value.length; i++) {
        this.switchOnTest[value[i] - 1] = false;
      }
      console.log(this.switchOnTest);
    },
    async clickSize(v) {
      await this.$store.dispatch("orderCategory/getCakeTexture", v);
      await this.$store.dispatch("orderCategorySub/getRelationship", v);
    },
    async clickCakeTexture(v) {
      await this.$store.dispatch("orderCategory/getFormat", v);
    },
    async clickFormat(v) {
      // await this.$store.dispatch("orderCategory/getFormat", v);
    },
  },
  async mounted() {
    await this.$store.dispatch("orderCategory/getSize");
    await this.$store.dispatch("orderCategorySub/fetch");
  },
  computed: {
    ...mapGetters({
      getSize: "orderCategory/getSize",
      getCakeTexture: "orderCategory/getCakeTexture",
      getFormat: "orderCategory/getFormat",
      getCategorySub: "orderCategorySub/fetch",
      getSubRelationship: "orderCategorySub/getRelationship",
    }),

    sumMainTotal() {
      let sum = [];
      const data = this.data;
      const dataNew = [
        ...this.getSize,
        ...this.getCakeTexture,
        ...this.getFormat,
      ];

      for (let i = 0; i < data.length; i++) {
        [sum[i]] = dataNew.filter((e) => {
          return e.id == data[i];
        });
      }

      const filter = sum.filter((e) => {
        if (e) {
          return e;
        }
      });

      const total = filter.reduce(
        (total, e) => total + parseFloat(e.price_special),
        0
      );

      return total;
    },

    sumSubTotal() {
      const sum = this.dhfiseojf.reduce(
        (total, e) => total + parseFloat(e.price),
        0
      );
      return sum;
    },

    sumTotal() {
      return this.sumMainTotal + this.sumSubTotal;
    },

    showSumTotal() {
      const data = this.data;
      const filter = data.filter((e) => {
        return e == null;
      });
      if (filter.length == 0) {
        return true;
      } else {
        return false;
      }
    },
  },
};
</script>

<style>
</style>