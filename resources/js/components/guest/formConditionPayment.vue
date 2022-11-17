<template>
    <div>
        <v-dialog persistent v-model="propDialog" scrollable width="500">
            <!-- <template v-slot:activator="{ on }">
        <v-checkbox
          v-on="on"
          hide-details
          class="mt-0"
          label="รับทราบและยอมรับเงื่อนไขทั้งหมด"
          v-model="submitCondition"
        ></v-checkbox>
      </template> -->
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    รายละเอียดเงื่อนไข
                </v-card-title>
                <v-card-text>
                    <textCondition></textCondition>
                    <!-- <p class="mt-2 text-subtitle-1 mb-0">
            1. โปรดชำระภายในวัน-เวลาที่กำหนด
          </p>
          <p class="text-subtitle-1 mb-0">
            2. ทางร้านขอสงวนสิทธิ์จัดคิวนัดรับสินค้า
            ให้กับลูกค้าท่านที่ชำระเงินก่อน
          </p>

          <p class="text-subtitle-1 mb-0">
            3. หากไม่สะดวกชำระมัดจำ (โปรดแจ้งเพื่อสำรองสินค้าและคิว) -
            รอตกแต่งสินค้า 15-30 นาที หรือตามที่พนักงานแจ้ง
            (เมื่อท่านถึงหน้าร้าน) **ยกเว้นสินค้ารูปแบบพิเศษ ที่ทางร้านแจ้ง
          </p>
          <p class="text-subtitle-1 mb-0">
            4. ทางร้านไม่มีนโยบายคืนเงินทุกกรณี
          </p>
          <p class="text-subtitle-1 mb-0">
            5. ภาพสินค้าของท่าน อาจถูกนำมาใช้งานในเพจของทางร้าน หากไม่ยินยอม
            โปรดแจ้งเพื่อลบออกได้ทุกเมื่อ
          </p>
          <p class="text-subtitle-1 mb-0">
            6. ทางร้านถือว่าลูกค้ายอมรับทุกข้อที่ทางร้านแจ้งค่ะ
          </p> -->
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn x-large @click="exit">
                        <v-icon left>cancel</v-icon>
                        ไม่ยินยอม
                    </v-btn>
                    <v-btn x-large class="success" @click="submit(true)">
                        <v-icon left>verified_user</v-icon>
                        ยินยอม
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import textCondition from "@/js/components/learning/conditions/order";
export default {
    props: ["propDialog"],
    components: { textCondition },
    data() {
        return {
            // submitCondition: false,
        };
    },
    methods: {
        // emitFormConditionPayment(value) {
        //   this.$emit("emitFormConditionPayment", value);
        // },
        async submit(v) {
            // this.emitFormConditionPayment(true);
            // this.submitCondition = true;
            let loader = this.$loading.show();
            const res = await this.$store.dispatch(
                "orderIndex/confirmConsentConditions",
                {
                    status_consent_condition: v,
                    uuid: this.$route.params.uuid,
                }
            );
            if (res.status === 200) {
                loader.hide();
                this.dialog = false;
            }
        },
        exit() {
            this.$swal({
                title: `คำแนะนำ`,
                icon: "info",
                allowOutsideClick: false,
                confirmButtonText: "รับทราบ",
                text: `โปรดรับทราบและยอมรับเงื่อนไขการใช้บริการ`,
            });
        },
    },
};
</script>
