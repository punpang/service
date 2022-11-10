<template>
    <div>
        <v-dialog width="350" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab small v-on="on" @click="clickSet()">
                    <v-icon>more_horiz</v-icon>
                </v-btn>
            </template>
            <formSelectForOrder
                @emitExit="emitExit"
                :propPosGoods="pos"
                :propGoods="this.propOrderGoods.pos_goods"
            ></formSelectForOrder>
        </v-dialog>
    </div>
</template>

<script>
import formSelectForOrder from "@/js/components/pos/goods/selectForOrder/_form";

export default {
    props: ["propOrderGoods"],
    components: { formSelectForOrder },
    data() {
        return {
            dialog: false,
            pos: {},
        };
    },
    methods: {
        async emitExit() {
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.propOrderGoods.order_id,
            });
            this.dialog = false;
            loader.hide();
        },
        clickSet() {
            this.pos = {
                text: "pos_update_goods_order",
                propOrderGoods: this.propOrderGoods,
            };
        },
    },
};
</script>

<style></style>
