<template>
  <div>
    <v-simple-table>
      <thead>
        <tr>
          <th width="15%">#</th>
          <th class="text-center" width="25%">จำนวนเงิน</th>
          <th class="text-center" width="25%">ช่องทางชำระเงิน</th>
          <th class="text-right" width="35%">วัน-เวลาที่ทำรายการ</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="paid in order.a_history_payed"
          :key="paid.id"
          class="white--text"
          :class="paid.status_use ? 'green' : 'red '"
        >
          <td>
            <v-container>
              <v-row>
                <v-btn x-small icon fab class="white--text" elevation="0">
                  <v-icon>refresh</v-icon>
                </v-btn>
                <cardShowSlip
                  v-if="paid.notice_of_payment_from_customer_id"
                  :propSrcName="paid.ntpfc.src_name"
                ></cardShowSlip>
                <cardShowKsherPay
                  v-if="paid.mch_order_no_of_ksher_pay"
                  :propKsherPay="paid.ksher_pay"
                ></cardShowKsherPay>
              </v-row>
            </v-container>
          </td>
          <td class="text-center">{{ paid.value | formatNumber }}</td>
          <td class="text-center">
            {{ paid.channel_payment.text }}
            <!-- <v-icon v-if="paid.notice_of_payment_from_customer_id" color="white"
              >image</v-icon
            > -->
          </td>
          <td class="text-right">
            {{ paid.date_time }}
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import cardShowSlip from "@/js/components/order/cardShowSlip";
import cardShowKsherPay from "@/js/components/order/cardShowKsherPay";
export default {
  components: {
    cardShowSlip,
    cardShowKsherPay,
  },
  methods: {
    setTextPaidStatus(v) {
      switch (v) {
        case 1:
          return "ใช้งาน";

        default:
          return "ยกเลิก";
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