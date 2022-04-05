<template>
    <div>
        <v-dialog persistent width="500" scrollable v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn class="success" v-on="on">
                    <v-icon left>add</v-icon>
                    สร้างใหม่
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    สร้างสินค้าเพิ่มเติม
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="py-2">
                    <formUpdateOrCreateGoodsAddOn></formUpdateOrCreateGoodsAddOn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import formUpdateOrCreateGoodsAddOn from "@/js/components/order/manages/goods/cake/addOn/goodsAddOn/formUpdateOrCreateGoodsAddOn";
export default {
    components: {
        formUpdateOrCreateGoodsAddOn,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        exit() {
            this.dialog = false;
        },
    },
};
</script>
