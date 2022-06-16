<template>
    <div>
        <v-alert color="error white--text" dense border="left" prominent>
            <v-row align="center">
                <v-col class="grow">ปรับยอดชำระเงินส่วนเกิน</v-col>
                <v-col class="shrink">
                    <btnAdjustExcessPayment></btnAdjustExcessPayment>
                </v-col>
            </v-row>
        </v-alert>
    </div>
</template>

<script>
import btnAdjustExcessPayment from "@/js/components/order/adjustExcessPayment/btn";
export default {
    components: {
        btnAdjustExcessPayment,
    },
};
</script>
