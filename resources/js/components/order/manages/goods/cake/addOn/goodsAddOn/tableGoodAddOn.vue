<template>
    <div>
        <v-text-field v-model="search" outlined hide-details label="ค้นหา">
        </v-text-field>
        <v-data-table
            :headers="headers"
            :items="goods_add_ons"
            items-per-page="5"
            :search="search"
        >
            <template v-slot:item.manages="{ item }">
                <btnEditGoodsAddOn :propGoodsAddOn="item"></btnEditGoodsAddOn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnEditGoodsAddOn from "@/js/components/order/manages/goods/cake/addOn/goodsAddOn/btnEditGoodsAddOn";
export default {
    data() {
        return {
            search: "",
            headers: [
                { text: "ชื่อเรียก", value: "name" },
                { text: "การจัดการ", value: "manages", align: "right" },
            ],
        };
    },
    components: {
        btnEditGoodsAddOn,
    },
    methods: {},
    computed: {
        ...mapGetters({
            goods_add_ons: "orderGoodsAddOn/fetch",
        }),
    },
};
</script>
