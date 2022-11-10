<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="propGoods"
            hide-default-footer
            :items-per-page="999"
            mobile-breakpoint="0"
        >
            <template v-slot:item.pos_goods.text="{ item }">
                <p class="font-weight-black mb-0">
                    {{ item.pos_goods.text }}
                </p>

                <p class="mb-0 caption deep-orange--text font-weight-bold">
                    {{ item.quantity }} x {{ item.price | formatNumber }}
                </p>
                <p class="mb-0 caption" v-if="item.note">
                    ** {{ item.note }} **
                </p>
                <!-- {{ item.quantity }} x {{ item.pos_goods.text }} @ -->
            </template>

            <template v-slot:item.total="{ item }">
                {{ item.total | formatNumber }}
            </template>

            <template v-slot:item.manages="{ item }">
                <updateSelectForOrder
                    :propOrderGoods="item"
                ></updateSelectForOrder>
            </template>
        </v-data-table>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
import updateSelectForOrder from "@/js/components/pos/goods/selectForOrder/update";
export default {
    props: ["propGoods"],
    components: { updateSelectForOrder },
    data() {
        return {
            headers: [
                { text: "ชื่อสินค้า", value: "pos_goods.text" },
                // { text: "จำนวน", value: "quantity", align: "end" },
                { text: "รวม", value: "total", align: "end" },
                { text: "", value: "manages", align: "end" },
            ],
        };
    },
};
</script>

<style></style>
