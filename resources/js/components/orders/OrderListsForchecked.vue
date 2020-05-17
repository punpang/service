<template>
    <v-dialog v-model="dialog" width="80%">
        <template v-slot:activator="{ on }">
            <span v-on="on"
                >มีรายการสั่งซื้ออื่น จำนวน {{ order.counts }} รายการ
                <b><u>รายละเอียด</u></b></span
            >
        </template>
        <v-card>
            <v-card-text>
                <OrderTableForCheckDateTimeGet
                    :dataTable="order.data"
                    :headers="headers"
                ></OrderTableForCheckDateTimeGet>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import OrderTableForCheckDateTimeGet from "@/js/components/orders/OrderTableForCheckDateTimeGet";
export default {
    name: "OrderListsForchecked",
    props: ["order"],
    components: {
        OrderTableForCheckDateTimeGet
    },
    data() {
        return {
            dialog: false,
            headers: [
                { text: "Order.", value: "id" },
                { text: "ชื่อลูกค้า", value: "customer_name" },
                { text: "เบอร์โทรลูกค้า", value: "customer_phone" },
                { text: "วัน-เวลาที่รับ", value: "dateTime_get" },
                { text: "สถานะ", value: "order_status_id", align: "center" },
            ]
        };
    }
};
</script>
