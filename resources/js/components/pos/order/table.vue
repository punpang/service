<template>
    <div>
        <v-card outlined>
            <v-card-title class="text-h6 white--text warning">
                สินค้าทั่วไป <v-spacer></v-spacer>
                <div class="font-weight-bold">
                    ฿ {{ propSumPos | formatNumber }}
                </div>
            </v-card-title>
            <v-card-text class="py-2">
                <v-data-table
                    :headers="headers"
                    :items="propGoods"
                    hide-default-footer
                    :items-per-page="-1"
                    mobile-breakpoint="0"
                    hide-default-header
                >
                    <template v-slot:item.pos_goods.text="{ item }">
                        <p class="font-weight-black mb-0 mt-1">
                            {{ item.pos_goods.text }}
                        </p>

                        <p
                            class="mb-0 caption deep-orange--text font-weight-bold"
                        >
                            {{ item.quantity }} x
                            {{ item.price | formatNumber }}
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
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
import updateSelectForOrder from "@/js/components/pos/goods/selectForOrder/update";
import { mapGetters } from "vuex";
export default {
    props: ["propGoods", "propSumPos"],
    components: { updateSelectForOrder },
    data() {
        return {
            headers: [
                { text: "ชื่อสินค้า", value: "pos_goods.text" },
                // { text: "จำนวน", value: "quantity", align: "end" },
                { text: "รวม", value: "total", align: "end" },
            ],
        };
    },
    mounted() {
        if (this.user.type == "1") {
            this.headers.push({ text: "", value: "manages" , align: "end"});
        }
    },
    computed: {
        ...mapGetters({
            user: "main/User",
        }),
    },
};
</script>

<style></style>
