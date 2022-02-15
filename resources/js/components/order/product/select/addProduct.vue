<template>
    <div>

        <v-divider></v-divider>
        {{ a_price }}
        <!-- <v-simple-table v-if="product.data.am1">
            <tbody>
                <tr>
                    <td colspan="2">
                        {{ product.data.name_goods }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ msg.text.price }}
                    </td>
                    <td class="text-right">
                        ฿ {{ product.data.price | formatNumber }}
                    </td>
                </tr>
            </tbody>
        </v-simple-table> -->
        <!-- // -->
        <!-- <cardMessage></cardMessage>
        <cardDetail></cardDetail> -->
        <!-- // -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";


import cardMessage from "@/js/components/order/product/select/cardMessage";
import cardDetail from "@/js/components/order/product/select/cardDetail";
export default {
    data() {
        return {
            a_price: {},
            message: "",
            detail: "",
        };
    },
    methods: {
        emitAPrice(v) {
            this.a_price = v;
        },
    },
    components: {
        selectCake,
        cardDetail,
        cardMessage,
    },
    computed: {
        ...mapGetters({
            // product: "orderProductCake/product",
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
        }),
    },
};
</script>
