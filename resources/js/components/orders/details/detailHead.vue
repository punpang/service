<template>
    <v-card>
        <v-card-title>
            รายการสั่งซื้อ
            <v-spacer></v-spacer>
            #{{ this.$store.getters['order/getByID'].data.id }}
        </v-card-title>
        <v-divider class="ma-1"></v-divider>
        <v-card-text class="px-0 pt-0">
            <v-container class="py-0">
                <OrderDetail :order="this.$store.getters['order/getByID'].data"></OrderDetail>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
import OrderDetail from "@/js/components/orders/details/detail";
export default {
    props: ["order"],
    components:{
        OrderDetail
    }
};
</script>

<style></style>
