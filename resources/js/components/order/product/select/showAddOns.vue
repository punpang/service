<template>
    <div>
        <v-card outlined>
            <v-card-title>
                ตัวเลือกเพิ่มเติม
                <v-spacer></v-spacer>
                <selectAddOn></selectAddOn>
            </v-card-title>
            <v-divider class="m-0"></v-divider>
            <v-card-text class="pa-0">
                <!-- {{ product }} -->
                <v-simple-table>
                    <tbody>
                        <tr v-for="(addOn, index) in propAddOns" :key="index">
                            <td>
                                <v-icon color="error">priority_high</v-icon>
                                + {{ addOn.goods_add_on.name }}
                                {{ addOn.price }} บาท
                            </td>
                            <!-- v-if="addOn.am4_id !== product.data.m4" -->
                            <td class="text-right">
                                <v-btn
                                    class="error"
                                    icon
                                    fab
                                    x-small
                                    dark
                                    @click="clickRemoveAddOn(index)"
                                >
                                    <v-icon>delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2" class="text-right">
                                <strong
                                    >รวม
                                    {{ product.sumAddOn | formatNumber }}
                                    บาท</strong
                                >
                            </td>
                        </tr> -->
                    </tbody>
                </v-simple-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import selectAddOn from "@/js/components/order/product/select/selectAddOn";

export default {
    props: ["propAddOns"],
    components: {
        selectAddOn,
    },
    data() {
        return {};
    },
    methods: {
        async clickRemoveAddOn(v) {
            await this.$store.commit("orderProductCake/removeProductAddOn", v);
        },
    },
    computed: {
        // ...mapGetters({
        //     product: "orderProductCake/product",
        // }),
    },
};
</script>
