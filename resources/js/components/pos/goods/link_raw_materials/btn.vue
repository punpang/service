<template>
    <div>
        <v-dialog width="700" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon>link</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ผูกวัตถุดิบ
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="clickExit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <tableLinkRawMaterial
                        :propGoods="propGoods"
                        @emitFetchGoods="emitFetchGoods"
                    ></tableLinkRawMaterial>
                    <div class="mt-2 d-flex flex-row justify-end">
                        <v-card
                            color="deep-orange"
                            class="d-flex align-center"
                            dark
                            height="60"
                            width="150"
                        >
                            <v-scroll-y-transition>
                                <div class="text-h5 flex-grow-1 text-center">
                                    {{
                                        propGoods.sum_cost_link_raw_material
                                            | formatNumber
                                    }}
                                </div>
                            </v-scroll-y-transition>
                        </v-card>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
// import tableRawMaterial from "@/js/components/pos/goods/raw_material/table";
import tableLinkRawMaterial from "@/js/components/pos/goods/link_raw_materials/table";
export default {
    props: ["propGoods"],
    components: { tableLinkRawMaterial },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitFetchGoods() {
            this.$emit("emitFetchGoods");
        },
        clickExit() {
            this.dialog = false;
        },
    },
};
</script>

<style></style>
