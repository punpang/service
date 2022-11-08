<template>
    <div>
        <v-tabs v-model="tab">
            <v-tab>สินค้า</v-tab>
            <v-tab>ประเภท</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item>
                <tableGoods></tableGoods>
            </v-tab-item>
            <v-tab-item>
                <tableCategoryGoods></tableCategoryGoods>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import tableGoods from "@/js/components/pos/goods/table";
import tableCategoryGoods from "@/js/components/pos/goods/categoryGoods/table";
export default {
    components: { tableGoods, tableCategoryGoods },
    data() {
        return {
            tab: null,
            items: ["สินค้า", "ประเภท"],
        };
    },
};
</script>

<style></style>
