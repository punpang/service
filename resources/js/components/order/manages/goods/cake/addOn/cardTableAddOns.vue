<template>
    <div>
        <v-simple-table>
            <tbody>
                <tr
                    v-for="(addon, index) in propOrderDetail.add_ons"
                    :key="index"
                >
                    <td class="text-left d-flex">
                        <cardCreateProductAddOn
                            v-if="addon.product_add_on.am4_id != propAm4"
                            :propAm4="propAm4"
                            :propGoodsAddOn="addon.product_add_on.goods_add_on"
                            @emitAutoUpdateAddOns="emitAutoUpdateAddOns"
                        ></cardCreateProductAddOn>

                        + {{ addon.price }}
                        {{ addon.product_add_on.goods_add_on.name }}
                    </td>
                    <td class="text-right">
                        <v-icon color="error" @click="clickRemove(addon)"
                            >delete</v-icon
                        >
                    </td>
                </tr>
            </tbody>
        </v-simple-table>
    </div>
</template>

<script>
import cardCreateProductAddOn from "@/js/components/order/manages/goods/cake/addOn/cardCreateProductAddOn";
export default {
    props: ["propOrderDetail", "propAm4"],
    components: {
        cardCreateProductAddOn,
    },
    methods: {
        async emitAutoUpdateAddOns() {
            let loader = this.$loading.show();
            const payload = {
                order_detail_id: this.propOrderDetail.id,
                order_id: this.propOrderDetail.order_id,
                m4: this.propOrderDetail.a_price.m4,
                add_ons: this.propOrderDetail.add_ons,
            };

            await this.$store.dispatch("orderIndex/autoUpdateAddOns", payload);
            loader.hide();
        },
        async clickRemove(v) {
            let loader = this.$loading.show();
            const payload = {
                order_detail_id: this.propOrderDetail.id,
                order_id: this.propOrderDetail.order_id,
                add_on: v,
            };
            await this.$store.dispatch("orderIndex/deleteAddOns", payload);
            this.$toast.success("ลบเรียบร้อย");
            loader.hide();
        },
    },
};
</script>
