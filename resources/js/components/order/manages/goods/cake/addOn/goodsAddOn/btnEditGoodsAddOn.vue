<template>
    <div>
        <v-dialog persistent width="500" scrollable v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small class="warning" dark v-on="on">
                    <v-icon>edit</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    แก้ไขสินค้าเพิ่มเติม
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="py-2">
                    <v-text-field
                        outlined
                        label="ชื่อเดิม"
                        hide-details
                        v-model="name"
                        readonly
                        disabled
                        class="mb-4"
                    ></v-text-field>
                    <formUpdateOrCreateGoodsAddOn
                        :propGoodsAddOn="propGoodsAddOn"
                    ></formUpdateOrCreateGoodsAddOn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import formUpdateOrCreateGoodsAddOn from "@/js/components/order/manages/goods/cake/addOn/goodsAddOn/formUpdateOrCreateGoodsAddOn";
export default {
    props: ["propGoodsAddOn"],
    components: {
        formUpdateOrCreateGoodsAddOn,
    },
    data() {
        return {
            dialog: false,
            name: this.propGoodsAddOn.name,
        };
    },
    methods: {
        exit() {
            this.dialog = false;
        },
    },
};
</script>
