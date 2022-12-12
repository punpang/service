<template>
    <div>
        <h2>รายการสินค้า</h2>
        <p class="text-subtitle-2 mb-1">สั่งซื้อวันนี้ รับราคาพิเศษ</p>
        <p class="text-subtitle-2">
            <strong>*ไม่มีนโยบายคืนเงินทุกกรณี*</strong>
        </p>
        <v-card outlined class="mb-3" v-if="user.type == 1">
            <v-card-title> ค้นหา </v-card-title>
            <v-card-text class="pb-0">
                <v-text-field
                    label="ราคาไม่เกิน"
                    outlined
                    dense
                    hide-details
                    class="mb-3"
                    v-model="search.price_rank"
                ></v-text-field>
                <v-combobox
                    v-model="search.tags"
                    :items="tags"
                    label="แท็ก"
                    multiple
                    outlined
                    dense
                    hide-details
                    class="mb-3"
                ></v-combobox>
            </v-card-text>
            <v-card-actions>
                <v-btn class="error" @click="clickSearchReset()">ล้าง</v-btn>
                <v-spacer></v-spacer>
                <v-btn class="success" @click="clickSearch()">ค้นหา</v-btn>
            </v-card-actions>
        </v-card>

        <v-row>
            <v-col
                cols="12"
                sm="6"
                md="4"
                lg="4"
                xl="4"
                v-for="product in products"
                :key="product.id"
            >
                <v-card outlined @click="clickToOrder(product.order_id)">
                    <imageThumbnailFullPathSizeFree
                        :path="product.image_for_menus[0]"
                        :size="500"
                        :propID="product.id"
                    >
                    </imageThumbnailFullPathSizeFree>

                    <v-card-text>
                        <div
                            class="d-flex flex-row text-body-2 font-weight-black"
                        >
                            {{ product.a_price.name_goods }}
                        </div>

                        <div
                            class="d-flex flex-row text-body-2 my-1 font-weight-bold deep-orange--text"
                        >
                            ฿{{ product.sum_price_for_menu | formatNumber }}
                        </div>

                        <div class="mt-1" v-if="product.add_ons.length > 0">
                            <strong>เพิ่มเติม : </strong>

                            {{ convert_add_on_name(product.add_ons) }}
                        </div>

                        <div class="mt-1" v-if="product.order_tags.length > 0">
                            <strong>แท็ก : </strong>

                            {{ convert_tags(product.order_tags) }}
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});

import { mapGetters } from "vuex";
import imageThumbnailFullPathSizeFree from "@/js/components/google/drive/imageThumbnailFullPathSizeFree";
export default {
    components: { imageThumbnailFullPathSizeFree },
    data() {
        return {
            //   path: "https://www.punpang.online/images/menu/",
            //   path: "http://192.168.1.103/images/menu/",
            products: [],
            search: {
                tags: [],
                price_rank: "",
            },
        };
    },
    methods: {
        clickSearchReset() {
            window.location.href = `/menu/orders`;
        },
        clickSearch() {
            let tags_url = "";
            for (let i = 0; i < this.search.tags.length; i++) {
                tags_url = `${tags_url}${this.search.tags[i].text},`;
            }
            const tags = tags_url.slice(0, -1)
                ? "&tags=" + tags_url.slice(0, -1)
                : "";

            const price_rank = this.search.price_rank
                ? `&price_rank=${this.search.price_rank}`
                : "";

            window.location.href = `/menu/orders?${tags}${price_rank}`;
        },
        clickToOrder(v) {
            console.log(this.user);
            if (this.user.type == 1) {
                window.location.href = `/manages/order/${v}/showOrderByID`;
                // window.location.href = `/manages/order/${v}/showOrderByID`;
            }
        },
        convert_tags(v) {
            let text = "";
            for (var i = 0; i < v.length; i++) {
                let comma = i != v.length - 1 ? "," : "";
                text = text + v[i].tag.text + comma;
            }
            return text;
        },

        convert_add_on_name(v) {
            let text = "";
            for (var i = 0; i < v.length; i++) {
                let comma = i != v.length - 1 ? "," : "";
                text = text + v[i].product_add_on.goods_add_on.name + comma;
            }
            return text;
        },
    },
    async mounted() {
        let loader = this.$loading.show();

        await this.$store.dispatch("orderTags/fetch", "status=true");

        const tags =
            this.$route.query.tags != undefined
                ? `&tags=${this.$route.query.tags}`
                : "";

        const price_rank =
            this.$route.query.price_rank != undefined
                ? `&price_rank=${this.$route.query.price_rank}`
                : "";

        const payload = `whereHas=imageForMenus,with=imageForMenus${tags}${price_rank}`;

        const result = await axios.get(
            `/api/v1/guest/product/punpang/order_details/fetch_for_menu?${payload}`
        );
        this.products = result.data;
        loader.hide();
    },
    computed: {
        ...mapGetters({ user: "main/User", tags: "orderTags/fetch" }),
    },
};
</script>
