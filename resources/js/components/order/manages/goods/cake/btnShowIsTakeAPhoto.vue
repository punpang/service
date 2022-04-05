<template>
    <div>
        <v-dialog
            persistent
            width="800"
            v-model="dialog"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <div v-on="on" style="cursor: pointer">
                    <v-icon
                        :color="
                            propOrderDetail.image_goods_review_to_customers
                                .length > 0
                                ? 'deep-purple'
                                : ''
                        "
                        >photo_camera</v-icon
                    >
                    <v-badge
                        :color="
                            propOrderDetail.image_goods_review_to_customers
                                .length > 0
                                ? 'green'
                                : 'grey'
                        "
                        dot
                        left
                    >
                        ถ่ายรูปสินค้า
                    </v-badge>
                </div></template
            >
            <v-card>
                <v-card-title class="text-h6">
                    ถ่ายรูปสินค้า
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="12">
                            <uploadImageMultiple
                                v-if="user.type === 1"
                                :propUploadImange="
                                    propOrderDetail.image_goods_review_to_customers
                                "
                                @emitImagesId="emitImagesId"
                                @emitRemoveImage="emitRemoveImage"
                            ></uploadImageMultiple>
                        </v-col>

                        <cardImageThumbnailPathSize800ForImageGoodsReviewToCustomer
                            :propImageGoodsReviewToCustomer="image"
                            :path="image.google_image.src_name"
                            v-for="(
                                image, index
                            ) in propOrderDetail.image_goods_review_to_customers"
                            :key="index"
                        ></cardImageThumbnailPathSize800ForImageGoodsReviewToCustomer>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import uploadImageMultiple from "@/js/components/google/drive/uploadImageMultiple";
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
import cardImageThumbnailPathSize800ForImageGoodsReviewToCustomer from "@/js/components/google/drive/cardImageThumbnailPathSize800ForImageGoodsReviewToCustomer";

export default {
    props: ["propOrderDetail"],
    components: {
        uploadImageMultiple,
        imageThumbnailPathSize800,
        cardImageThumbnailPathSize800ForImageGoodsReviewToCustomer,
    },
    data() {
        return {
            dialog: false,
            test: [],
        };
    },
    methods: {
        async emitImagesId(imagesData) {
            // let loader = this.$loading.show();
            const data = {
                order_detail_id: this.propOrderDetail.id,
                imgs: imagesData,
            };
            const result = await this.$store.dispatch(
                "orderImageGoodsReviewToCustomer/store",
                data
            );

            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.$route.params.id,
                });
                this.start();
                this.$swal({
                    title: "อัปโหลดรูปทั้งหมดเรียบร้อย",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    icon: "success",
                });
            } else {
                this.$swal({
                    title: "เกิดข้อผิดพลาดบางประการ",
                    text: "โปรดลองอีกครั้งภายหลัง หรือ ติดต่อทางร้าน 091-885-3402",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    icon: "error",
                });
            }

            loader.hide();
        },
        async emitRemoveImage(imageId) {
            let loader = this.$loading.show();
            const data = {
                uuid: this.$route.params.uuid,
                order_detail_id: this.propOrderDetail.id,
                imagesData: imageId,
            };
            const res = await this.$store.dispatch(
                "orderGuestUuid/removeImageIdByUUID",
                data
            );

            if (res.status == 200) {
                this.start();
                this.$swal({
                    title: res.data.message,
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            } else {
                this.$swal({
                    title: "เกิดข้อผิดพลาดบางอย่าง",
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            }

            loader.hide();
        },
        exit() {
            this.dialog = false;
        },
    },
    computed: {
        ...mapGetters({
            user: "main/User",
        }),
    },
};
</script>
