<template>
    <div>
        <v-row>
            <v-col cols="6" md="6">ชื่อลูกค้า</v-col>
            <v-col cols="6" md="6" class="text-right">{{ order.customer_not_f_b.name }}</v-col>
        </v-row>
        <v-row>
            <v-col cols="6" md="6">เบอร์โทรศัพท์</v-col>
            <v-col cols="6" md="6" class="text-right">{{ order.customer_not_f_b.phone }}</v-col>
        </v-row>
        <v-row>
            <v-col cols="5" md="6">วัน-เวลารับสินค้า</v-col>
            <v-col cols="7" md="6" class="text-right">{{ order.dateTime_get }}</v-col>
        </v-row>
        <v-row>
            <v-col cols="6" md="6">สถานะ</v-col>
            <v-col cols="6" md="6" class="text-right">{{
                order.order_status.name
            }}</v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    props: ["order"]
};
</script>

<style></style>
