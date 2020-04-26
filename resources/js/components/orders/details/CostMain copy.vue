<template>
    <v-card>
        <v-card-title>
            ค่าใช้จ่าย
        </v-card-title>
        <v-divider class="ma-1"></v-divider>
        <v-card-text class="pt-0">
            <CostSub :sum="this.$store.getters['orderDetail/sum']"></CostSub>
        </v-card-text>
    </v-card>
</template>

<script>
import CostSub from '@/js/components/orders/details/CostSub'

export default {
    components:{
        CostSub
    }
};
</script>

<style></style>
