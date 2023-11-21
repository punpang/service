<template>
    <tr>
        <tdBtnUseCoupon
            v-if="propOrder.coupon_used == null"
            :propOrder="propOrder"
        ></tdBtnUseCoupon>
        <td colspan="2">
            <v-row>
                <v-col class="py-0" cols="10" md="8">
                    <strong> ใช้โค้ด </strong>
                    <p class="ma-0 text-caption">
                        {{ propOrder.coupon_used.coupon.code }}
                    </p>
                </v-col>
                <v-col class="py-0 d-flex align-center justify-end text-right" cols="2" md="4">
                    <strong class="error--text">-{{ propOrder.coupon_used.discount }}.00</strong>
                </v-col>
            </v-row>
        </td>
    </tr>
</template>

<script>
import tdBtnUseCoupon from "@/js/components/order/manages/useCoupon/tdBtn.vue";

export default {
    props: ["propOrder"],
    components: {
        tdBtnUseCoupon,
    },
};
</script>

<style></style>
