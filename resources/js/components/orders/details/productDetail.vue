<template>
    <v-row>
        <v-col cols="12" md="4" class="pb-0">
            <imageThumbnailPathSize800
                :path="detail.product.product_image.src_name"
            ></imageThumbnailPathSize800>
        </v-col>
        <v-col cols="12" md="8">
            <v-row class="px-4">
                <span class="title font-weight-bold">{{
                    detail.product.name
                }}</span>
                <v-spacer></v-spacer>
                <span class="title font-weight-bold"
                    >X{{ detail.quantity }}</span
                >
            </v-row>
            <p
                class="mb-0"
                v-for="tag in detail.product.product_tag_use_only"
                :key="tag.id"
            >
                {{ tag.product_category_sub_use_only.product_category.name }}
                :
                {{ tag.product_category_sub_use_only.name }}
            </p>

            <p class="mb-0" v-if="detail.write_status">
                เขียนข้อความ : {{ detail.write }}
            </p>

            <p class="mb-0" v-if="detail.note_status">
                หมายเหตุ : {{ detail.note }}
            </p>
            <v-divider class="my-2"></v-divider>
            <p class="mb-0">ราคา/หน่วย {{ detail.price }} บาท</p>
            <p class="mb-0">รวมราคา {{ detail.sum_price }} บาท</p>
        </v-col>
    </v-row>
</template>

<script>
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";

export default {
    props: ["detail"],
    components:{
        imageThumbnailPathSize800
    }
};
</script>

<style></style>
