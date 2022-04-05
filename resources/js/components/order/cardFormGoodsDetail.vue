<template>
    <div>
        <div
            class="mb-2"
            v-for="detail in order.order_details"
            :key="detail.id"
        >
            <v-card-text>
                <v-row>
                    <v-col cols="3" md="3" class="pa-2">
                        <v-img
                            src="https://www.punpangsv.com/admin_system/home/product/img-products/3FE0FF85-F7DE-4ED2-A5EF-77C4955186C1_1_201_a.png"
                        ></v-img>
                    </v-col>
                    <v-col cols="9" md="9" class="pa-2">
                        <p class="mb-0">
                            <strong>{{ detail.a_price.name_goods }}</strong>
                        </p>
                        <p class="mb-0" v-if="detail.message != '-'">
                            <strong>ข้อความ </strong>
                            <strong class="text-subtitle-1">{{
                                detail.message
                            }}</strong>
                        </p>
                        <p class="mb-0" v-if="detail.detail != '-'">
                            <strong>รายละเอียด </strong>
                            <strong class="text-subtitle-1">{{
                                detail.detail
                            }}</strong>
                        </p>
                        <p class="mb-0">
                            <strong>ราคา </strong>
                            {{ detail.a_price.price }} บาท
                        </p>
                        <v-divider class="my-1"></v-divider>
                        <p
                            class="mb-0"
                            v-for="(addOn, index) in detail.add_ons"
                            :key="index"
                        >
                            + {{ addOn.price | formatNumber }}
                            {{ addOn.product_add_on.goods_add_on.name }}
                        </p>
                        <p class="mb-0">
                            รวมตัวเลือกเพิ่มเติม
                            {{ detail.sum_all.add_on }} บาท
                        </p>
                        <v-divider class="my-1"></v-divider>
                        <p>รวมทั้งหมด {{ detail.sum_all.total }} บาท</p>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider class="my-1"></v-divider>
            <!-- <v-card-text class="pa-1" v-if="user.type === 1">
                <v-container>
                    <v-row>
                        <editCake :propOrderDetail="detail"></editCake>

                        <cardManageAddOn
                            :propOrderDetail="detail"
                        ></cardManageAddOn>

                        <removeCake :propOrderDetail="detail"></removeCake>
                    </v-row>
                </v-container>
            </v-card-text> -->
             <!-- <v-divider class="my-1"></v-divider> -->
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import editCake from "@/js/components/order/manages/editCake";
// import removeCake from "@/js/components/order/manages/removeCake";
import cardManageAddOn from "@/js/components/order/manages/cardManageAddOn";


export default {
    components: {
        editCake,
        // removeCake,
        cardManageAddOn
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            setNameGoods: "orderIndex/setNameGoods",
            user: "main/User",
        }),
    },
};
</script>
