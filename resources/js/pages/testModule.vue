<template>
  <div>
    <v-card class="mx-auto" max-width="400">
      <v-form ref="formCreateOTP" lazy-validation>
        <v-card-text v-if="step == 1">
          <v-text-field
            outlined
            label="หมายเลขโทรศัพท์"
            class="mb-0"
            v-model="form.phoneNumber"
            type="number"
            pattern="\d*"
            autofocus
            :counter="10"
            :rules="[
              (v) => !!v || 'ห้ามเว้นว่าง',
              (v) => v.length == 10 || 'กรอกเบอร์โทร 10 หลักเท่านั้น',
              (v) => {
                const pattern = /[0]{1}[0-9]{9}/;
                return (
                  pattern.test(v) ||
                  'กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น'
                );
              },
            ]"
            prepend-icon="call"
          >
          </v-text-field>
          <v-btn color="info" block large @click="countDownTimer(), sendOTP()">
            <v-icon left>sms</v-icon>
            รับรหัส OTP
          </v-btn>
        </v-card-text>
      </v-form>

      <v-card-text v-if="step == 2">
        <v-row>
          <v-col cols="12" md="12" class="pb-0">
            <p class="subtitle-1 text-center">
              รหัสยืนยันตัวตน จะถูกส่งไปทาง SMS ที่
            </p>
            <p class="subtitle-1 mb-0 text-center">
              {{ form.phoneNumber }}
            </p>
          </v-col>
          <v-col cols="12" md="12">
            <v-form ref="formVerifyOTP" lazy-validation>
              <v-text-field
                outlined
                placeholder="OTP"
                large
                class="mb-0"
                type="number"
                pattern="\d*"
                autofocus
                v-model="formVerify.ref2"
                :counter="6"
                :rules="[
                  (v) => !!v || 'ห้ามเว้นว่าง',
                  (v) => {
                    const pattern = /[0-9]{6}/;
                    return (
                      pattern.test(v) || 'โปรดกรอกเฉพาะตัวเลข 6 หลัก เท่านั้น'
                    );
                  },
                  (v) => v.length == 6 || 'โปรดกรอกเฉพาะตัวเลข 6 หลัก เท่านั้น',
                ]"
              ></v-text-field>
              <v-btn color="success" block large @click="clickVerify()"
                >ยืนยันตัวตน</v-btn
              >
              <p
                class="mb-0 mt-4 subtitle-1 text-center"
                v-show="formVerify.ref1"
              >
                อ้างอิง : {{ formVerify.ref1 }}
              </p>
            </v-form>
          </v-col>
        </v-row>

        <p
          class="red--text text-center mt-4 mb-0 subtitle-1"
          v-if="countDown > 0"
        >
          กรุณารอ {{ countDown }} วินาที ก่อนกด "ส่งอีกครั้ง" อีกครั้ง
        </p>

        <p class="text-center mt-4 mb-0 subtitle-1" v-else>
          <b @click="sendOTP()">ส่งอีกครั้ง</b> |
          <b @click="clearPhone()">เปลี่ยนหมายเลข</b>
        </p>
      </v-card-text>

      <v-card-text v-if="step == 3">
        <p class="text-center mb-0 subtitle-1">
          <b @click="sendOTP()">ส่งอีกครั้ง</b> |
          <b @click="clearPhone()">เปลี่ยนหมายเลข</b>
        </p>
      </v-card-text>
    </v-card>
    <overlay :overlay="overlay"></overlay>
  </div>
</template>

<script>
import overlay from "@/js/layouts/overlay";

export default {
  components: {
    overlay,
  },
  data() {
    return {
      countDown: 0,
      step: 1,
      form: {
        phoneNumber: "",
      },
      formVerify: {
        phoneNumber: "",
        ref1: "",
        ref2: "",
      },
      overlay: false,
    };
  },
  methods: {
    countDownTimer() {
      setTimeout(() => {
        this.countDown -= 1;
        this.countDownTimer();
      }, 1000);
    },
    addTime() {
      this.countDown = 60;
    },
    async sendOTP() {
      if (this.$refs.formCreateOTP.validate()) {
        this.overlay = true;
        const res = await this.$store.dispatch("smsOTP/sendOTP", this.form);

        if (res.data.status == 200) {
          this.$toast.success(res.data.message);
          this.formVerify = {
            phoneNumber: this.form.phoneNumber,
            ref1: res.data.data.ref1,
            ref2: ""
          };
          this.step = 2;
        } else if (res.data.status == 500) {
          this.$toast.error(res.data.message);
          this.step = 3;
        } else {
          this.$toast.warning("ระบบขัดข้อง : โปรดลองใหม่อีกครั้งภายหลัง");
        }

        this.addTime();
        this.overlay = false;
      }
    },
    clearPhone() {
      this.form.phoneNumber = "";
      this.step = 1;
    },
    async clickVerify() {
      if (this.$refs.formVerifyOTP.validate()) {
        this.overlay = true;
        const res = await this.$store.dispatch(
          "smsOTP/verify",
          this.formVerify
        );

        if (res.status == 200) {
          if (res.data.status == 200 || res.data.verified == true) {
            this.$toast.success(res.data.message);
          } else if (res.data.status == 500) {
            this.$toast.warning(res.data.message);
          } else if (res.data.status == 501) {
            this.$toast.error(res.data.message);
          }
        }
        this.overlay = false;
      }
    },
  },
};
</script>
