<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                ข้อมูลลูกค้า
                <v-spacer></v-spacer>
                <btnUpdateCustomer
                    v-if="user.type == 1"
                    :propCustomer="order.customer"
                ></btnUpdateCustomer>
            </v-card-title>
            <v-card-text>
                <v-simple-table>
                    <tbody>
                        <tr>
                            <td>
                                <strong>ชื่อ</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ order.customer.name }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                        <tr>
                            <td>
                                <strong>เบอร์โทร</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{
                                    user.type == 1
                                        ? order.customer.tel
                                        : order.customer.phone_format
                                }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                        <tr v-if="user.type == 1">
                            <td>
                                <strong>คะแนนสะสม</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{
                                    order.customer.sum_diff_score | formatNumber
                                }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                        <tr v-if="user.type == 1">
                            <td colspan="2">
                                <a
                                    v-if="social_startWith()"
                                    target="_blank"
                                    :href="order.customer.social_is"
                                    >FACEBOOK_LINK</a
                                >
                                <a target="_blank" :href="user_link()"
                                    >USER_LINK</a
                                >
                            </td>
                        </tr>
                    </tbody>
                </v-simple-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
import { mapGetters } from "vuex";
import btnUpdateCustomer from "@/js/components/order/customer/update/btn";
export default {
    components: { btnUpdateCustomer },
    methods: {
        social_startWith() {
            if (
                this.order.customer.social_is.startsWith(
                    "https://www.facebook.com"
                )
            ) {
                return true;
            }
            return false;
        },
        user_link() {
            // window.location.href = `/o/${this.order.auth_order}`;
            return `/o/${this.order.auth_order}`;
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            user: "main/User",
        }),
    },
};
</script>
