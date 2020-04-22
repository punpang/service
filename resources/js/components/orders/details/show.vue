<template>
    <div>
        <v-card>
            <v-card-title>
                รายละเอียด
                <v-spacer></v-spacer>
                <v-icon @click="clickMenu">dehaze</v-icon>
            </v-card-title>
            <v-divider class="ma-1"></v-divider>
        </v-card>
        <div v-if="this.$store.getters['orderDetail/getByOrderId'].length > 0">
            <v-card
                v-for="detail in this.$store.getters[
                    'orderDetail/getByOrderId'
                ]"
                :key="detail.id"
                class="mt-4"
            >
                <v-card-text class="pa-0">
                    <v-container class="py-0">
                        <v-row>
                            <v-col cols="12" md="4">
                                <imageThumbnail
                                    :src="detail.product.product_image"
                                ></imageThumbnail>
                            </v-col>
                            <v-col cols="12" md="8">
                                <span class="title font-weight-bold">{{
                                    detail.product.name
                                }}</span>
                                <br />
                                <p
                                    class="mb-0"
                                    v-for="tag in detail.product
                                        .product_tag_use_only"
                                    :key="tag.id"
                                >
                                    {{
                                        tag.product_category_sub_use_only
                                            .product_category.name
                                    }}
                                    :
                                    {{ tag.product_category_sub_use_only.name }}
                                </p>
                                <p>ร่าคา {{ detail.price }}.00 บาท</p>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </div>
        <v-alert type="info" v-else>
            ยังไม่มีสินค้า
        </v-alert>
    </div>
</template>

<script>
import imageThumbnail from "@/js/components/google/drive/imageThumbnail";

export default {
    components: {
        imageThumbnail,
    },
    data() {
        return {};
    },
    methods: {
        clickMenu() {
            this.$emit("emitClickMenu");
        }
    }
};
</script>

<style></style>
