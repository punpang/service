<template>
    <v-card>
        <v-card-title>
            รายการสั่งซื้อ
            <v-spacer></v-spacer>
            #{{ order.id }}0582
        </v-card-title>
        <v-divider class="ma-1"></v-divider>
        <v-card-text class="px-0 pt-0">
            <v-container class="py-0">
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
                        <span>{{ order.order_status.name }}</span>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ["order"]
};
</script>

<style></style>
