<template>
    <div>
        <v-card>
            <v-card-title>
                รายละเอียด
                <v-spacer></v-spacer>
                <v-icon @click="start" color="success">refresh</v-icon>
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
                            <v-col cols="12" md="4" class="pb-0">
                                <imageThumbnail
                                    :src="detail.product.product_image"
                                ></imageThumbnail>
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

                                <p class="mb-0" v-if="detail.write_status">
                                    เขียนข้อความ : {{ detail.write }}
                                </p>

                                <p class="mb-0" v-if="detail.note_status">
                                    หมายเหตุ : {{ detail.note }}
                                </p>
                                <v-divider class="my-2"></v-divider>
                                <p class="mb-0">
                                    ราคา/หน่วย {{ detail.price }} บาท
                                </p>
                                <p class="mb-0">
                                    รวมราคา {{ detail.sum_price }} บาท
                                </p>
                            </v-col>
                        </v-row>

                            <v-col cols="12" md="12">
                                <v-row>
                                    <formDetail
                                        :detail="detail"
                                        :action="action.update.detail"
                                    ></formDetail>
                                    <v-btn
                                        color="primary"
                                        v-if="detail.upload_image_status"
                                        class="mr-2"
                                    >
                                        <v-icon left>link</v-icon>
                                        ส่งลิงก์อัปโหลดรูป
                                    </v-btn>
                                    <v-btn color="error" class="mr-2">
                                        <v-icon left>cancel</v-icon>
                                        ยกเลิก
                                    </v-btn>
                                </v-row>
                            </v-col>

                            <v-col
                                cols="12"
                                md="12"
                                class="pt-0 d-flex d-sm-none"
                                v-if="1 == 2"
                            >
                                <v-btn
                                    color="primary"
                                    v-if="detail.upload_image_status"
                                    class="mr-2"
                                    fab
                                    small
                                >
                                    <v-icon>link</v-icon>
                                    <!-- ส่งลิงก์อัปโหลดรูป -->
                                </v-btn>
                                <v-btn color="error" class="mr-2" fab small>
                                    <v-icon>cancel</v-icon>
                                    <!-- ยกเลิก -->
                                </v-btn>
                            </v-col>
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
import formDetail from "@/js/components/orders/details/_form_detail";

export default {
    components: {
        imageThumbnail,
        formDetail
    },
    data() {
        return {
            action: {
                update: {
                    detail: {
                        method: "update",
                        title: "แก้ไขสินค้า",
                        icon: "edit"
                    }
                }
            }
        };
    },
    methods: {
        start() {
            this.$emit("emitStart");
        }
    }
};
</script>

<style></style>
