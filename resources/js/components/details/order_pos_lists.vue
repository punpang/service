<template>
    <div>
        <v-card class="mb-4" outlined v-for="order in pos" :key="order.id">
            <v-card-title class="text-h6">
                Order :: {{ order.id }}
                <v-spacer></v-spacer>
                <v-btn
                    icon
                    fab
                    x-small
                    class="deep-orange"
                    dark
                    @click="clickToOrder(order.id)"
                >
                    <v-icon>search</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-btn x-small :class="order.a_status.class" elevation="0" class="mb-1">{{
                    order.a_status.status
                }}</v-btn>
                <p class="font-weight-bold mb-0">วัน-เวลานัดรับสินค้า</p>
                <p class="mb-4 caption">
                    {{ order.date_get_th }}
                    {{ order.time_get_format }} น.
                </p>
                <div v-for="pos_order in order.pos_orders" :key="pos_order.id">
                    <v-divider class="my-2"></v-divider>
                    <p class="mb-1">
                        <strong>{{ pos_order.pos_goods.text }}</strong>
                    </p>
                    <p class="mb-0 caption deep-orange--text font-weight-bold">
                        {{ pos_order.quantity }} x
                        {{ pos_order.price | formatNumber }}
                    </p>
                    <p
                        class="mb-0 caption font-weight-bold"
                        v-if="pos_order.note"
                    >
                        ** {{ pos_order.note }} **
                    </p>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    methods: {
        clickToOrder(id) {
            window.location.href = `/manages/order/${id}/showOrderByID`;
        },
    },
    computed: {
        ...mapGetters({
            pos: "orderIndex/orders_details_pos",
        }),
    },
};
</script>

<style></style>
