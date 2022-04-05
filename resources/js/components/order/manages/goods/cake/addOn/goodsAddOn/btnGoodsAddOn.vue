<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn class="teal" dark v-on="on">
                    <v-icon left>store</v-icon>
                    สินค้า</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    สินค้าเพิ่มเติม
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <tableGoodAddOn></tableGoodAddOn>
                </v-card-text>
                <v-card-actions>
                    <v-btn class="info" @click="fetch()">
                        <v-icon left>refresh</v-icon>
                        โหลดใหม่
                    </v-btn>
                    <v-spacer></v-spacer>
                    <btnUpdateOrCreateGoodsAddOn></btnUpdateOrCreateGoodsAddOn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import tableGoodAddOn from "@/js/components/order/manages/goods/cake/addOn/goodsAddOn/tableGoodAddOn";
import btnUpdateOrCreateGoodsAddOn from "@/js/components/order/manages/goods/cake/addOn/goodsAddOn/btnUpdateOrCreateGoodsAddOn";
export default {
    components: {
        tableGoodAddOn,
        btnUpdateOrCreateGoodsAddOn,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        async fetch() {
            let loader = this.$loading.show();
            const payload = {};
            await this.$store.dispatch("orderGoodsAddOn/fetch", payload);
            loader.hide();
        },
        exit() {
            this.dialog = false;
        },
    },
};
</script>
