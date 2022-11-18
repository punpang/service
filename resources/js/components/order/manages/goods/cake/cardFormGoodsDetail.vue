<template>
    <div>
        <div
            class="mb-2"
            v-for="detail in order.order_details"
            :key="detail.id"
        >
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="12" class="px-2 pb-0 pt-1">
                        <v-row>
                            <v-col
                                :cols="user.type != 1 ? 12 : 9"
                                :md="user.type != 1 ? 12 : 10"
                            >
                                <strong>{{ detail.a_price.name_goods }}</strong>
                            </v-col>
                            <v-col
                                cols="3"
                                md="2"
                                class="text-right"
                                v-if="user.type == 1"
                            >
                                <btnCardManagesCake
                                    v-if="order.status < 8"
                                    :propOrderDetail="detail"
                                ></btnCardManagesCake>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="3" md="3" class="pa-2">
                        <!-- <v-img
                            src="https://www.punpangsv.com/admin_system/home/product/img-products/3FE0FF85-F7DE-4ED2-A5EF-77C4955186C1_1_201_a.png"
                        ></v-img> -->
                        <imageThumbnailPathSizeW200H200
                            v-if="
                                detail.a_price.google_image ||
                                detail.product_prototypes.length > 0
                            "
                            :path="
                                detail.product_prototypes.length > 0
                                    ? detail.product_prototypes[0].google_image
                                          .src_name
                                    : detail.a_price.google_image.src_name
                            "
                        ></imageThumbnailPathSizeW200H200>
                    </v-col>
                    <v-col cols="9" md="9" class="pa-2">
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
                            {{ detail.price }} บาท
                        </p>
                        <div
                            class="my-2 d-flex"
                            v-if="
                                detail.status_upload_images_from_customer ||
                                detail.product_prototypes.length > 0 ||
                                detail.is_take_a_photo
                            "
                        >
                            <btnUploadImagesForOrderDetail
                                :propOrderDetail="detail"
                                :propImageFormCustomers="
                                    detail.image_from_customers
                                "
                                v-if="detail.status_upload_images_from_customer"
                                class="mx-1"
                            ></btnUploadImagesForOrderDetail>

                            <btnShowProductPrototype
                                v-if="detail.product_prototypes.length > 0"
                                :propProductPrototypes="
                                    detail.product_prototypes
                                "
                                class="mx-1"
                            ></btnShowProductPrototype>

                            <btnShowIsTakeAPhoto
                                class="mx-1"
                                v-if="detail.is_take_a_photo"
                                :propOrderDetail="detail"
                            ></btnShowIsTakeAPhoto>
                        </div>
                        <p class="my-2"></p>
                        <div v-if="detail.add_ons.length > 0">
                            <v-divider class="my-1"></v-divider>
                            <p
                                class="mb-0"
                                v-for="(addOn, index) in detail.add_ons"
                                :key="index"
                            >
                                <v-icon
                                    color="error"
                                    v-if="
                                        addOn.product_add_on.am4_id !=
                                        detail.a_price.m4
                                    "
                                    >priority_high</v-icon
                                >
                                + {{ addOn.price | formatNumber }}
                                {{ addOn.product_add_on.goods_add_on.name }}
                            </p>
                            <p class="mb-0">
                                รวมตัวเลือกเพิ่มเติม
                                {{ detail.sum_all.add_on }} บาท
                            </p>
                        </div>

                        <v-divider class="my-1"></v-divider>
                        <p>รวมทั้งหมด {{ detail.sum_all.total }} บาท</p>
                    </v-col>
                    <v-col cols="12" md="12">
                        <showMoneyService
                            :propMoneyService="detail.money_services"
                        ></showMoneyService>
                    </v-col>
                </v-row>
            </v-card-text>
            <!-- <v-divider class="my-1"></v-divider>
            <div v-if="user.type === 1">
                <v-card-text class="pa-1">
                    <v-container>
                        <v-row>
                            <editCake :propOrderDetail="detail"></editCake>

                            <cardManageAddOn
                                :propOrderDetail="detail"
                            ></cardManageAddOn>

                            <removeCake :propOrderDetail="detail"></removeCake>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-divider class="my-1"></v-divider>
            </div> -->
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
// import editCake from "@/js/components/order/manages/goods/cake/editCake";
// import removeCake from "@/js/components/order/manages/goods/cake/removeCake";
// import cardManageAddOn from "@/js/components/order/manages/goods/cake/addOn/cardManageAddOn";
import btnCardManagesCake from "@/js/components/order/manages/goods/cake/btnCardManagesCake";
import btnShowProductPrototype from "@/js/components/order/manages/goods/cake/productPrototype/btnShowProductPrototype";
import btnShowIsTakeAPhoto from "@/js/components/order/manages/goods/cake/btnShowIsTakeAPhoto";
import btnUploadImagesForOrderDetail from "@/js/components/guest/btnUploadImagesForOrderDetail";
import imageThumbnailPathSizeW200H200 from "@/js/components/google/drive/imageThumbnailPathSizeW200H200";
import showMoneyService from "@/js/components/order/manages/goods/cake/moneyService/show";
// import imageThumbnailFullPathSizeW200H200 from "@/js/components/google/drive/imageThumbnailFullPathSizeW200H200"
export default {
    components: {
        // editCake,
        // removeCake,
        // cardManageAddOn,
        btnCardManagesCake,
        btnShowProductPrototype,
        btnUploadImagesForOrderDetail,
        btnShowIsTakeAPhoto,
        imageThumbnailPathSizeW200H200,
        showMoneyService,
        // imageThumbnailFullPathSizeW200H200
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
