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
      if (this.form.sumCountCustomer <= 0) {
        this.$swal({
          title: "จำนวนลูกค้าอย่างน้อย 1 คน",
          icon: "warning",
          confirmButtonText: "รับทราบ",
          confirmButtonColor: "#1E88E5",
        });
        return;
      }

      if (
        this.form.count_Adolescence +
          this.form.count_Adult +
          this.form.count_Elder <=
        0
      ) {
        this.$swal({
          title: "ต้องมีเด็กโต, ผู้ใหญ่ , ผู้สูงอายุ รวมกันอย่างน้อย 1 คน",
          icon: "warning",
          confirmButtonText: "รับทราบ",
          confirmButtonColor: "#1E88E5",
        });
        return;
      }

      if (this.form.cookingType.length <= 0) {
        this.$swal({
          title: "โปรดเพิ่มเตาอย่างน้อย 1 รายการ",
          icon: "warning",
          confirmButtonText: "รับทราบ",
          confirmButtonColor: "#1E88E5",
        });
        return;
      }

      let loader = this.$loading.show();
      const form = {
        data: this.form,
        tableNumber: this.dataTable.id,
      };

      if (this.$refs.form.validate()) {
        await this.$store
          .dispatch("diningTable/store", form)
          .then((response) => {
            if (response.status === 200) {
              this.$store.dispatch("diningTable/allTable");
              this.$toast.success(response.data.message);
            } else if (response.status === 201) {
              this.$toast.warning(response.data.message);
            } else if (response.status === 202) {
              this.dialog = false;
              this.$swal({
                icon: "error",
                title: response.data.message,
                confirmButtonText: "รับทราบ",
                confirmButtonColor: "#1E88E5",
              });
            }
          })
          .catch((errors) => {
            this.$toast.error(errors);
          });
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
        cookingType: [],
      };
      this.dialog = false;
    },
    emitPriceRange(v) {
      this.form.priceRange_id = v;
    },
  },
};
</script>