<template>
  <div>
    <v-card>
      <v-card-title>
        <h2>ลงทะเบียนลุ้นโชค</h2>
      </v-card-title>
      <v-card-text>
        <v-form ref="formRegister" lazy-validation>
          <v-row justify="center">
            <v-col md="5">
              <v-text-field
                label="ชื่อลูกค้า"
                prepend-icon="person"
                outlined
                v-model="datas.customers.name"
                hide-details
                :rules="rules.name"
                autofocus
              ></v-text-field>
            </v-col>
          </v-row>
          <!-- //// -->
          <v-row justify="center">
            <v-col md="5">
              <v-text-field
                label="เบอร์โทรลูกค้า"
                prepend-icon="phone"
                outlined
                v-model="datas.customers.phone"
                hide-details
                pattern="\d*"
                type="number"
                :rules="rules.phone"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-form>
        <!-- //// -->
        <v-row justify="center" class="mt-3">
          <v-col md="3" cols="7">
            <v-text-field
              label="OTP 4 หลัก"
              prepend-icon="vpn_key"
              outlined
              v-model="otp"
              hide-details
              pattern="\d*"
              type="number"
              :rules="rules.otp"
            ></v-text-field>
          </v-col>
          <v-col md="2" cols="5">
            <v-btn class="success" block height="100%" large @click="get_otp">
              <v-icon left>sms</v-icon>
              รับรหัส
            </v-btn>
          </v-col>
        </v-row>

        <!-- //// -->
        <v-form ref="formNORS" lazy-validation>
          <div class="mt-3" v-if="verify_otp == otp">
            <v-row justify="center">
              <v-col md="5">
                <v-select
                  label="จำนวนสิทธิ์"
                  prepend-icon="casino"
                  outlined
                  v-model="datas.number_of_right"
                  hide-details
                  :items="nors"
                  item-value="value"
                  :rules="rules.nors"
                >
                </v-select>
              </v-col>
            </v-row>
            <!-- //// -->
            <v-row justify="center">
              <v-col md="5" class="pb-0">
                <v-btn class="success" block large @click="register">
                  ลงทะเบียน
                </v-btn>
              </v-col>
            </v-row>
            <!-- //// -->
            <v-row justify="center">
              <v-col md="5">
                <v-btn class="error" block large @click="reset">
                  ล้างข้อมูล
                </v-btn>
              </v-col>
            </v-row>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
    <!-- {{ datas }} -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      datas: {
        number_of_right: "",
        customers: {
          name: "",
          phone: "",
        },
      },
      otp: "",
      verify_otp: "xxxx",
      nors: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], //number of rights
      rules: {
        name: [(v) => !!v || "ห้ามเว้นว่าง"],
        phone: [
          (v) => !!v || "ห้ามเว้นว่าง",
          (v) => v.length == 10 || "กรอกเบอร์โทร 10 หลักเท่านั้น",
          (v) => {
            const pattern = /[0]{1}[0-9]{9}/;
            return (
              pattern.test(v) ||
              "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น"
            );
          },
        ],
        otp: [
          (v) => !!v || "ห้ามเว้นว่าง",
          (v) => v.length == 4 || "กรอกรหัส OTP 4 หลัก",
          (v) => {
            const pattern = /[0-9]{4}/;
            return pattern.test(v) || "กรุณกรอกรหัส OTP 4 หลัก";
          },
        ],
        nors: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    async get_otp() {
      if (this.$refs.formRegister.validate()) {
        let loader = this.$loading.show();
        const random_otp = Math.floor(1000 + Math.random() * 9000);
        this.verify_otp = random_otp;
        const data = {
          phone: this.datas.customers.phone,
          random_otp: random_otp,
        };

        const res = await this.$store.dispatch("orderLuckyReward/getOTP", data);

        /// TEST START ///
        // const res = {
        //   data: {
        //     success: true,
        //     message: "SMS SUCCESS !!",
        //   },
        // };
        // this.otp = random_otp;
        /// TEST END ///
        
        loader.hide();

        if (res.data.success === true) {
          this.$swal({
            title: res.data.message,
            icon: "success",
            allowOutsideClick: false,
            confirmButtonText: `เรียบร้อย`,
          });
        } else {
          this.$swal({
            title: "เกิดข้อผิดพลาด",
            icon: "error",
            allowOutsideClick: false,
            confirmButtonText: `รับทราบ`,
          });
        }
      }
    },
    async register() {
      if (
        this.$refs.formRegister.validate() &&
        this.$refs.formNORS.validate() &&
        this.verify_otp == this.otp
      ) {
        let loader = this.$loading.show();
        const data = this.datas;
        const res = await this.$store.dispatch(
          "orderLuckyReward/register",
          data
        );

        loader.hide();
        if (res.data.success === true) {
          this.$swal({
            title: res.data.message,
            icon: "success",
            allowOutsideClick: false,
            confirmButtonText: `เรียบร้อย`,
          });
        }

        this.reset();
      }
    },
    reset() {
      this.datas = {
        number_of_right: "",
        customers: {
          name: "",
          phone: "",
        },
      };
      this.otp = "";
      this.verify_otp = "xxxx";
    },
  },
};
</script>