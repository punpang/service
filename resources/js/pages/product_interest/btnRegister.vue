<template>
    <div>
        <v-dialog persistent width="800" v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn class="info" v-on="on">
                    <v-icon left>save</v-icon>
                    เลือกสินค้า
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    เลือกสินค้า
                    <v-spacer></v-spacer>
                    <v-btn fab icon x-small @click="clickExit">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <tableGoods
                        :propSelectForProductInterest="true"
                        @emitAddGoodsProductInterest="
                            emitAddGoodsProductInterest
                        "
                    ></tableGoods>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import tableGoods from "@/js/components/pos/goods/table";
export default {
    components: { tableGoods },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitAddGoodsProductInterest(propGoods) {
            this.$emit("emitAddGoodsProductInterest", propGoods);
        },
        clickExit() {
            this.dialog = false;
        },
    },
};
</script>

<style></style>
