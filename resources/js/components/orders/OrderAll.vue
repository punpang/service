<template>
    <div>
        <v-container>
            <v-row>
                <OrderCreate></OrderCreate>
            </v-row>
        </v-container>
        <v-data-table
            :items="this.$store.getters['order/all']"
            :headers="headers"
            :search="search"
            :items-per-page="15"
            item-key="id"
        >
            <template v-slot:item.customer_name="{ item }">
                {{ item.customer.name }}
            </template>

            <template v-slot:item.customer_phone="{ item }">
                {{ item.customer.phone }}
            </template>

            <template v-slot:item.channel_of_purchase_id="{ item }">
                {{ item.channel_of_purchase.name }}
            </template>

            <template v-slot:item.order_status_id="{ item }">
                {{ item.order_status.name }}
            </template>

            <template v-slot:item.action="{ item }">
                <v-btn class="warning" fab x-small><v-icon>edit</v-icon></v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import OrderCreate from "@/js/components/orders/OrderCreate";
export default {
    components: {
        OrderCreate
    },
    data() {
        return {
            search: "",
            searchSelect: "",
            headers: [
                { text: "NO.", value: "id" },
                {
                    text: "ชื่อลูกค้า",
                    value: "customer_name"
                },
                { text: "เบอร์โทรลูกค้า", value: "customer_phone" },
                { text: "วัน-เวลาที่รับ", value: "dateTime_get" },
                { text: "วัน-เวลาที่สั่งซื้อ", value: "created_at" },
                { text: "ช่องทางการสั่งซื้อ", value: "channel_of_purchase_id" },
                { text: "สถานะ", value: "order_status_id" },
                { text: "การจัดการ", value: "action", align: "end" }
            ],
            searchSelectData: [
                { id: 1, name: "สร้างออร์เดอร์" },
                { id: 231351, name: "รอยืนยันการสั่งซื้อ" }
            ]
        };
    },
    async created() {
        await this.$store.dispatch("order/all");
    }
};
</script>

<style></style>
