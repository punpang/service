<template>
    <div>
        <div v-if="order.status != 9">
            <v-alert
                text
                :type="order.sumAll.sumDeposited == 0 ? 'warning' : 'success'"
                border="left"
                class="mb-2"
            >
                <strong v-if="order.sumAll.sumDeposited == 0"
                    >โปรดชำระเงินก่อน <br class="d-flex d-sm-none" />
                    {{ order.payment_deadline_th }} น.</strong
                >
                <strong v-else
                    >ขอบคุณที่ชำระเงินเพื่อยืนยันการสั่งซื้อค่ะ</strong
                >
                <p
                    class="mb-0"
                    v-show="
                        !order.status_payment_deadline &&
                        order.sumAll.sumDeposited == 0
                    "
                >
                    เนื่องจากเกินกำหนดชำระเงิน
                    หากท่านยังต้องการสั่งซื้อรายการนี้
                    โปรดติดต่อทางร้านเพื่อขยายเวลาชำระเงินได้ที่
                    <a href="https://m.me/punpangpranburi">FACEBOOK</a> หรือ
                    โทร.
                    <a href="tel:091-885-3402">091-885-3402</a>
                </p>
                <v-spacer></v-spacer>
                <formPayment
                    class="mt-1"
                    v-if="
                        (order.status_payment_deadline &&
                            order.sumAll.sumDeposited == 0) ||
                        (order.sumAll.sumDeposited > 0 &&
                            order.sumAll.sumBalance > 0)
                    "
                ></formPayment>
            </v-alert>
            <v-sheet
                class="mx-auto pa-2 mb-2"
                outlined
                v-if="order.ntpfcs_for_customer.length > 0"
            >
                <v-slide-group show-arrows>
                    <v-slide-item>
                        <cardFormNoticeOfPaymentByCustomer
                            v-if="order.ntpfcs_for_customer.length > 0"
                            class="mx-1"
                        ></cardFormNoticeOfPaymentByCustomer>
                    </v-slide-item>
                </v-slide-group>
            </v-sheet>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import formPayment from "@/js/components/guest/formPayment";
import cardFormNoticeOfPaymentByCustomer from "@/js/components/guest/cardFormNoticeOfPaymentByCustomer";

export default {
    components: {
        formPayment,
        cardFormNoticeOfPaymentByCustomer,
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
