<template>
    <div>
        <v-tabs v-model="tab">
            <v-tab>สินค้า</v-tab>
            <v-tab>ประเภท</v-tab>
            <v-tab>วัตถุดิบ</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item>
                <tableGoods></tableGoods>
            </v-tab-item>
            <v-tab-item>
                <tableCategoryGoods></tableCategoryGoods>
            </v-tab-item>
            <v-tab-item>
                <tableRawMaterial></tableRawMaterial>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import tableGoods from "@/js/components/pos/goods/table";
import tableCategoryGoods from "@/js/components/pos/goods/categoryGoods/table";
import tableRawMaterial from "@/js/components/pos/goods/raw_material/table";
export default {
    components: { tableGoods, tableCategoryGoods, tableRawMaterial },
    data() {
        return {
            tab: null,
            items: ["สินค้า", "ประเภท"],
        };
    },
};
</script>

<style></style>
