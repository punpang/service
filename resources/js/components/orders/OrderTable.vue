<template>
    <div>
        <v-data-table
            :items="dataTable"
            :headers="headers"
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
                <v-btn :class="item.order_status.style" block small rounded>{{
                    item.order_status.name
                }}</v-btn>
            </template>

            <template v-slot:item.action="{ item }">
                    <OrderManages class="mr-2" :order="item"></OrderManages>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import OrderManages from "@/js/components/orders/OrderManages";
export default {
    props: ["dataTable", "headers"],
    components: {
        OrderManages
    }
};
</script>

<style></style>
