<template>
    <div>
        <v-card
            v-for="detailTemp in detailTemps"
            :key="detailTemp.id"
            class="mb-2"
        >
            <!-- <v-card-title>
                <strong>{{ temp.a_price.name_goods }}</strong>
            </v-card-title> -->
            <v-card-text>
                <v-row>
                    <v-col cols="3" md="3" class="pa-2">
                        <v-img
                            src="https://www.punpangsv.com/admin_system/home/product/img-products/3FE0FF85-F7DE-4ED2-A5EF-77C4955186C1_1_201_a.png"
                        ></v-img>
                    </v-col>
                    <v-col cols="9" md="9" class="pa-2">
                        <p class="mb-0">
                            <strong>{{
                                detailTemp.temp.a_price.name_goods
                            }}</strong>
                        </p>
                        <p class="mb-0" v-if="detailTemp.temp.message != '-'">
                            <strong>ข้อความ </strong>
                            <strong class="text-subtitle-1">{{
                                detailTemp.temp.message
                            }}</strong>
                        </p>
                        <p class="mb-0" v-if="detailTemp.temp.detail != '-'">
                            <strong>รายละเอียด </strong>
                            <strong class="text-subtitle-1">{{
                                detailTemp.temp.detail
                            }}</strong>
                        </p>
                        <p class="mb-0">
                            <strong>ราคา </strong>
                            {{ detailTemp.temp.a_price.price }} บาท
                        </p>
                        <!-- <v-divider class="my-1"></v-divider>
                        <p
                            class="mb-0"
                            v-for="(addOn, index) in detailTemp.temp.add_ons"
                            :key="index"
                        >
                            + {{ addOn.price | formatNumber }}
                            {{ addOn.goods_add_on.name }}
                        </p> -->
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider class="my-0"></v-divider>
            <v-card-text class="pa-1" v-if="user.type === 1">
                <v-container>
                    <v-row>
                        <editCake :propDetailTemp="detailTemp"></editCake>

                        <!-- <cardManageAddOn
                            :propDetailTemp="detailTemp"
                        ></cardManageAddOn> -->

                        <removeCake :propDetailTemp="detailTemp"></removeCake>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
        <!-- <v-simple-table>
            <tbody>
                <tr v-for="{ temp, index } in detailTemps" :key="index">
                    <td>รูปภาพ</td>
                    td
                    <td>
                        <p>{{ temp.a_price.name_goods }}</p>

                        <p class="my-2" v-if="temp.message != null">
                            <strong>{{ msg.text.message }}</strong>
                            <strong class="subtitle-2 mb-2 pl-3">{{
                                temp.message
                            }}</strong>
                        </p>



                        <p class="my-2" v-if="temp.detail != null">
                            <strong>{{ msg.text.detail }}</strong>
                            <strong class="subtitle-2 mb-2 pl-3">{{
                                temp.detail
                            }}</strong>
                        </p>
                    </td>
                </tr>
            </tbody>
        </v-simple-table> -->
    </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});
import { mapGetters } from "vuex";
import productSelectCake from "@/js/components/order/product/select/cake";
import cardManageAddOn from "@/js/components/order/product/select/cardManageAddOn";
import editCake from "@/js/components/order/product/select/editCake";
import removeCake from "@/js/components/order/product/select/removeCake";

export default {
    components: {
        productSelectCake,
        cardManageAddOn,
        editCake,
        removeCake,
    },
    data() {
        return {};
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            detailTemps: "orderDetailTemp/temps",
            user: "main/User",
        }),
        // sumAddOn() {
        //     return this.add_ons.reduce((sum, { price }) => {
        //         return parseInt(sum + price);
        //     }, 0);
        // },
    },
};
</script>
