<template>
    <div>
        <v-dialog width="350" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon color="info">file_download</v-icon>
                </v-btn>
            </template>
            <createSelectForOrder
                :propGoods="propGoods"
                :propPosGoods="propPosGoods"
                @emitExit="emitExit"
            ></createSelectForOrder>
        </v-dialog>
    </div>
</template>

<script>
import createSelectForOrder from "@/js/components/pos/goods/selectForOrder/_form";
export default {
    props: ["propGoods", "propPosGoods"],
    components: { createSelectForOrder },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitExit() {
            this.dialog = false;
        },
    },
};
</script>

<style></style>
