<template>
  <v-dialog v-model="dialog" persistent width="500">
    <template v-slot:activator="{ on }">
      <v-card v-on="on" color="grey lighten-1">
        <v-card-text class="white--text text-center">
          <h1 class="ma-4">{{ dataTable.name }}</h1>
        </v-card-text>
      </v-card>
    </template>
    <v-card>
      <v-card-title class="pb-0">
        <h3 class="mb-0">เปิดโต๊ะใหม่ : {{ dataTable.name }}</h3>
        <v-spacer></v-spacer>
        <v-btn icon fab x-small @click="exit()">
          <v-icon color="error">close</v-icon>
        </v-btn>
      </v-card-title>
      <v-divider class="mb-0"> </v-divider>
      <v-form ref="form" lazy-validation>
        <v-card-text>
          <countCustomer :propformCount="form"></countCustomer>
          <v-divider></v-divider>
          <selectPriceRange
            @emitPriceRange="emitPriceRange"
            :propFormPriceRange="form"
          ></selectPriceRange>
          <v-divider class="mt-0"></v-divider>
          <cookingType
            :propSumCountCustomer="form.sumCountCustomer"
            :propCookingType="form.cookingType"
          ></cookingType>
        </v-card-text>
      </v-form>
      <v-divider class="ma-0"></v-divider>
      <v-card-actions>
        <v-row>
          <v-col class="px-2">
            <v-btn color="success" x-large block @click="save()">
              <v-icon left>local_dining</v-icon>
              เปิดโต๊ะ</v-btn
            ></v-col
          >
          <v-col class="px-2">
            <v-btn color="error" x-large block @click="exit()">
              <v-icon left>exit_to_app</v-icon>
              ออก</v-btn
            ></v-col
          >
        </v-row>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import countCustomer from "@/js/components/shabuNoonee/diningTable/addTable/countCustomer";
import selectPriceRange from "@/js/components/shabuNoonee/diningTable/addTable/selectPriceRange";
import cookingType from "@/js/components/shabuNoonee/diningTable/addTable/cookingType";

export default {
  components: {
    countCustomer,
    selectPriceRange,
    cookingType,
  },
  props: ["dataTable"],
  data() {
    return {
      dtest: 0,
      dialog: false,
      form: {
        count_Infant: 0, //1
        count_Children: 0, //2
        count_Adolescence: 0, //3
        count_Adult: 0, //4
        count_Elder: 0, //5
        sumCountCustomer: 0,
        priceRange_id: null,
        cookingType: [],
      },
    };
  },
  methods: {
    async save() {
      let loader = this.$loading.show();
      const form = {
        count: this.form,
        tableNumber: this.dataTable.id,
      };

      if (this.$refs.form.validate() && this.form.sumCountCustomer > 0) {
        const res = await this.$store.dispatch("diningTable/store", form);
        if (res.status === 200) {
          this.$toast.success(res.data.message);
        } else if (res.status === 201) {
          this.$toast.warning(res.data.message);
        }
        this.dialog = false;
      } else {
        this.$toast.error("โปรดกรอกข้อมูลให้ครบถ้วน");
      }
      loader.hide();
    },
    exit() {
      this.form = {
        count_Infant: 0, //1
        count_Children: 0, //2
        count_Adolescence: 0, //3
        count_Adult: 0, //4
        count_Elder: 0, //5
        sumCountCustomer: 0,
        priceRange_id: null,
      };
      this.dialog = false;
    },
    emitPriceRange(v) {
      this.form.priceRange_id = v;
    },
  },
};
</script>