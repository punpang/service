<template>
    <div>
        <v-data-table
            :items="dataTable"
            :headers="headers"
            hide-default-footer
            item-key="id"
        >   
            <template v-slot:item.id="{ item }">
                #{{ item.id }}
            </template>

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
                <v-btn :class="item.order_status.style" block small>{{
                    item.order_status.name
                }}</v-btn>
            </template>

            <template v-slot:item.action="{ item }">
                    <OrderManages :order="item"></OrderManages>
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
