<template>
    <div>
        <v-card
            v-for="{ temp, index } in detailTemps"
            :key="index"
            class="mb-2"
        >
            <!-- <v-card-title>
                <strong>{{ temp.data.name_goods }}</strong>
            </v-card-title> -->
            <v-card-text>
                <v-row>
                    <v-col cols="3" md="3" class="pa-2">
                        <v-img
                            src="https://www.punpangsv.com/admin_system/home/product/img-products/3FE0FF85-F7DE-4ED2-A5EF-77C4955186C1_1_201_a.png"
                        ></v-img>
                    </v-col>
                    <v-col cols="9" md="6" class="pa-2">
                        <p class="mb-0">
                            <strong>{{ temp.data.name_goods }}</strong>
                        </p>
                        <p class="mb-0" v-if="temp.message != '-'">
                            <strong>ข้อความ </strong>
                            <strong class="text-subtitle-1">{{
                                temp.message
                            }}</strong>
                        </p>
                        <p class="mb-0" v-if="temp.detail != '-'">
                            <strong>รายละเอียด </strong>
                            <strong class="text-subtitle-1">{{
                                temp.detail
                            }}</strong>
                        </p>
                        <p class="mb-0">
                            + {{ temp.data.price | formatNumber }}
                        </p>
                        <v-divider class="my-1"></v-divider>
                        <p
                            class="mb-0"
                            v-for="addOn in temp.addOns"
                            :key="addOn.index"
                        >
                            + {{ addOn.price | formatNumber }}
                            {{ addOn.goods_add_on.name }}
                        </p>
                        <!-- <v-divider class="my-1"></v-divider> -->
                        <!-- <p>
                            <strong>{{
                                (temp.sumAddOn + temp.data.price) | formatNumber
                            }}</strong>
                        </p> -->
                    </v-col>
                    <!-- <v-col cols="12" md="3" class="pa-2">
                        <showAddOns :propAddOns="temp.addOns"></showAddOns>
                        <productSelectCake
                            :propProduct="temp"
                        ></productSelectCake>
                    </v-col> -->
                </v-row>
            </v-card-text>
            <v-divider class="my-0"></v-divider>
            <v-card-text class="pa-1">
                <v-btn elevation="0" class="white">
                    <v-icon left>edit</v-icon>
                    แก้ไขสินค้า</v-btn
                >
                <v-btn elevation="0" class="white">
                    <v-icon left>playlist_add</v-icon>
                    ตัวเลือกเพิ่มเติม</v-btn
                >
                <v-btn class="white" elevation="0">
                    <v-icon left>delete</v-icon>
                    ลบสินค้า</v-btn
                >
            </v-card-text>
        </v-card>
        <!-- <v-simple-table>
            <tbody>
                <tr v-for="{ temp, index } in detailTemps" :key="index">
                    <td>รูปภาพ</td>
                    td
                    <td>
                        <p>{{ temp.data.name_goods }}</p>

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
import showAddOns from "@/js/components/order/product/select/showAddOns";

export default {
    components: {
        productSelectCake,
        showAddOns,
    },
    data() {
        return {};
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            detailTemps: "orderDetailTemp/temps",
        }),
    },
};
</script>
