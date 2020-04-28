<template>
    <div>
        <v-data-table :headers="headers" :items="payments" hide-default-footer :items-per-page="50">
            <template v-slot:item.order_payment_method_id="{ item }"
                >{{ item.order_payment_method.name }}</template
            >

            <template v-slot:item.status="{ item }">
                <setStautsColorText :status="item.status"></setStautsColorText>
            </template>

            <template v-slot:item.action="{ item }">
                <cancelPayment :payment="item"></cancelPayment>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import cancelPayment from "@/js/components/orders/payments/cancelPayment";
import setStautsColorText from "@/js/components/orders/payments/setStautsColorText";

export default {
    props: ["payments"],
    components: {
        cancelPayment,
        setStautsColorText
    },
    data() {
        return {
            headers: [
                { text: "เลขที่ใบเสร็จ", value: "bill_id" },
                { text: "จำนวนเงิน", value: "amount" },
                {
                    text: "ช่องทางชำระเงิน",
                    value: "order_payment_method_id",
                    align: "center"
                },
                {
                    text: "วัน-เวลาทำรายการ",
                    value: "updated_at",
                    align: "center"
                },
                { text: "สถานะ", value: "status", align: "center" },
                { text: "การจัดการ", value: "action", align: "end" }
            ]
        };
    }
};
</script>

<style></style>
