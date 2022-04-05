<template>
    <div>
        <v-dialog v-model="dialog" persistent width="800" scrollable transition="dialog-top-transition">
            <template v-slot:activator="{ on }">
                <div v-on="on">
                    <v-icon color="green accent-4">insert_photo</v-icon>
                    {{ user.type === 1 ? "รูปภาพ" : "อัปโหลดรูปภาพ" }}
                </div>
                <!-- <v-btn v-on="on">
                    @click="save()" :disabled="!self.id"
                    <span class="white--text"> อัปโหลดรูปภาพ </span>
                    <v-icon class="white--text">file_upload</v-icon>
                </v-btn> -->
            </template>
            <v-card>
                <v-card-title>
                    {{ user.type === 1 ? "รูปภาพ" : "อัปโหลดรูปภาพ" }}
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="exit">close</v-icon>
                </v-card-title>
                <v-card-text class="pt-2">
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                            class="pa-1"
                            v-if="user.type != 1"
                        >
                            <uploadImageMultiple
                                :propUploadImange="propImageFormCustomers"
                                @emitImagesId="emitImagesId"
                                @emitRemoveImage="emitRemoveImage"
                            ></uploadImageMultiple>
                        </v-col>

                        <cardImageThumbnailPathSize800
                            v-for="(image, index) in propImageFormCustomers"
                            :path="image.google_image.src_name"
                            :propImageFormCustomer="image"
                            :key="index"
                        ></cardImageThumbnailPathSize800>
                    </v-row>

                    <!-- <uploadImageMultiple
                        v-else
                        :propUploadImange="propImageFormCustomers"
                        @emitImagesId="emitImagesId"
                        @emitRemoveImage="emitRemoveImage"
                    ></uploadImageMultiple> -->
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import uploadImageMultiple from "@/js/components/google/drive/uploadImageMultiple";
import cardImageThumbnailPathSize800 from "@/js/components/google/drive/cardImageThumbnailPathSize800";
import { mapGetters } from "vuex";
export default {
    props: ["propImageFormCustomers", "propOrderDetail"],
    components: {
        uploadImageMultiple,
        cardImageThumbnailPathSize800,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        exit() {
            this.dialog = false;
        },
        start() {
            this.$emit("emitStart");
        },
        async emitImagesId(imagesData) {
            let loader = this.$loading.show();
            const data = {
                uuid: this.$route.params.uuid,
                order_detail_id: this.propOrderDetail.id,
                imagesData: imagesData,
            };

            const result = await this.$store.dispatch(
                "orderGuestUuid/uploadImagesByUUID",
                data
            );

            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByUUID", {
                    uuid: this.$route.params.uuid,
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
    },
    computed: {
        ...mapGetters({ user: "main/User" }),
    },
};
</script>
