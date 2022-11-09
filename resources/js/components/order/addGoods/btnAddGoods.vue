<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="500"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-title class="py-1"
                        >{{ text.header }}
                    </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    {{ text.header }}
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6">
                                <btnAddCake></btnAddCake>
                            </v-col>
                            <v-col cols="12" md="6">
                                <btnAddGoodsPos></btnAddGoodsPos>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import btnAddCake from "@/js/components/order/addGoods/btnAddCake";
import btnAddGoodsPos from "@/js/components/order/addGoodsPos/create";
export default {
    components: { btnAddCake, btnAddGoodsPos },
    data() {
        return {
            dialog: false,
            text: {
                header: "เพิ่มสินค้า",
            },
        };
    },
    methods: {},
};
</script>
