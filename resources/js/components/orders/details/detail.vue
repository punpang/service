<template>
    <v-row>
        <v-col cols="12" md="12" class="pb-0">
            <b>ชื่อลูกค้า</b>
            <v-spacer></v-spacer>
            {{ order.customer.name }}
        </v-col>
        <v-col cols="12" md="12" class="pb-0">
            <b>เบอร์โทรศัพท์</b>
            <v-spacer></v-spacer>
            {{ order.customer.phone }}
        </v-col>
        <v-col cols="12" md="12" class="pb-0">
            <b>วัน-เวลารับสินค้า</b>
            <v-spacer></v-spacer>
            {{ order.dateTime_get }}
        </v-col>
        <v-col cols="12" md="12" class="pb-0">
            <b>สถานะ</b>
            <v-spacer></v-spacer>
            <span>{{
                order.order_status.name
            }}</span>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: ["order"]
};
</script>

<style></style>
