<template>
  <div>
    <v-dialog width="500" v-model="dialog" scrollable>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="cyan" dark >
          <v-icon left>image</v-icon>
          สลิป</v-btn
        >
      </template>
      <v-card>
        <v-card-title class="text-h6 white--text warning">
          ประวัติการโอนชำระเงิน
          <v-spacer></v-spacer>
          <v-btn icon fab x-small class="white" @click="dialog = false">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="px-2">
          <v-card
            class="mt-2"
            outlined
            v-for="notice in order.ntpfcs_for_customer"
            :key="notice.id"
          >
            <v-card-text>
              <v-row>
                <v-col cols="6" class="pt-2 pl-2 pb-2 pr-0">
                  <v-img
                    :src="
                      'https://drive.google.com/thumbnail?id=' +
                      notice.src_name +
                      '&sz=w800-h800'
                    "
                  ></v-img>
                </v-col>
                <v-col cols="6" class="pr-0 pt-2 pb-2 pl-2">
                  <p class="mb-0"><strong>วัน-เวลาที่ทำรายการ</strong></p>
                  <p class="text-caption mb-1">
                    {{ notice.created_at }}
                  </p>
                  <p class="mb-0"><strong>จำนวนเงิน</strong></p>
                  <p class="text-caption mb-1">
                    {{ notice.amount | formatNumber }}
                    บาท
                  </p>

                  <p class="mb-0"><strong>สถานะ</strong></p>
                  <p
                    class="text-caption mb-1"
                    :class="classNoticeStatus(notice.status)"
                  >
                    {{ textNoticeStatus(notice.status) }}
                  </p>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    textNoticeStatus(v) {
      switch (v) {
        case "create":
          return "รอตรวจสอบรายการ";
        case "success":
          return "รายการสำเร็จ";
        case "cancel":
          return "ยกเลิกรายการ";
      }
    },
    classNoticeStatus(v) {
      switch (v) {
        case "create":
          return "info--text";
        case "success":
          return "success--text";
        case "cancel":
          return "error--text";
      }
    },
  },
  computed: {
    ...mapGetters({
      order: "orderIndex/order",
    }),
  },
};
</script>