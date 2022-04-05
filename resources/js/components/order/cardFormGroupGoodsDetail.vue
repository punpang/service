<template>
    <div>
        
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import cardFormGoodsDetail from "@/js/components/order/cardFormGoodsDetail";

export default {
    components: {
        cardFormGoodsDetail,
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            setNameGoods: "orderIndex/setNameGoods",
        }),
    },
};
</script>
