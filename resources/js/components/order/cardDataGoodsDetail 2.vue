<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                ข้อมูลสินค้า
            </v-card-title>
            <v-card-text class="pa-0">
                <cardFormGoodsDetail></cardFormGoodsDetail>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import cardFormGoodsDetail from "@/js/components/order/manages/goods/cake/cardFormGoodsDetail";
export default {
    components: {
        cardFormGoodsDetail,
    },
};
</script>
