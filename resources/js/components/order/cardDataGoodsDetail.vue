<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                ข้อมูลสินค้า
            </v-card-title>
            <v-card-text class="pt-4">
                <v-card
                    outlined
                    class="mb-2"
                    v-for="order in order.order_details"
                    :key="order.id"
                >
                    <v-card-text>
                        <p>
                            <strong>{{ order.a_price.name_goods }}</strong>
                        </p>

                        <p>
                            <strong>เขียนข้อความ</strong>
                        </p>


                    </v-card-text>
                </v-card>
                <v-simple-table>
                    <tbody>
                        <div
                            v-for="order in order.order_details"
                            :key="order.id"
                        >
                            <!-- {{ order }} -->
                            <tr
                                v-if="
                                    order.m1 !== 99 ||
                                    order.m2 !== 99 ||
                                    order.m3 !== 99 ||
                                    order.m4 !== 99
                                "
                            >
                                <td colspan="2">
                                    <strong
                                        >{{ order.a_price.name_goods }}
                                    </strong>
                                </td>
                            </tr>
                            <!-- / -->
                            <tr v-if="order.detail !== null">
                                <td>
                                    <strong>ข้อมูลเพิ่มเติม</strong>
                                </td>
                                <td class="text-right">
                                    <strong>
                                        {{ order.detail }}
                                    </strong>
                                </td>
                            </tr>
                            <!-- / -->
                            <tr v-if="order.message !== null">
                                <td>
                                    <strong>เขียนข้อความ</strong>
                                </td>
                                <td class="text-right">
                                    <strong>{{ order.message }}</strong>
                                </td>
                            </tr>
                            <!-- / -->
                            <!-- <tr v-if="order.other !== '-'">
                                <td>
                                    <strong>หมายเหตุ</strong>
                                </td>
                                <td class="text-right">
                                    <strong>{{ order.other }}</strong>
                                </td>
                            </tr> -->
                            <!-- / -->
                        </div>
                    </tbody>
                </v-simple-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            setNameGoods: "orderIndex/setNameGoods",
        }),
    },
};
</script>
