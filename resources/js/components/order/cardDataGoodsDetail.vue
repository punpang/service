<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                ข้อมูลสินค้า
            </v-card-title>
            <v-card-text class="pt-4">
                <cardFormGoodsDetail></cardFormGoodsDetail>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import cardFormGoodsDetail from "@/js/components/order/cardFormGoodsDetail";
export default {
    components: {
        cardFormGoodsDetail,
    },
};
</script>
