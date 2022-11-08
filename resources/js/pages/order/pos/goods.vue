<template>
    <div>
        <createGoods></createGoods>
        <createCategoryGoods></createCategoryGoods>
        <v-divider></v-divider>
        <tableGoods></tableGoods>
    </div>
</template>

<script>
import createGoods from "@/js/components/pos/goods/create";
import createCategoryGoods from "@/js/components/pos/goods/categoryGoods/create";
import tableGoods from "@/js/components/pos/goods/table";

export default {
    components: { createGoods, createCategoryGoods, tableGoods },
};
</script>

<style></style>
