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
                <!-- <v-btn elevation="0" class="white" v-on="on" :block="propBlock">
                    <v-icon left>attach_file</v-icon>
                    <div>อัปโหลดรูปสำหรับเมนู</div>
                </v-btn> -->
                <div v-on="on" style="cursor: pointer">
                    <v-icon color="cyan accent-4">attach_file</v-icon>
                    รูปสำหรับเมนู
                </div>
                <!-- <v-list-item v-on="on">
                    <v-list-item-icon>
                        <v-icon>attach_file</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="py-2">อัปโหลดรูปสำหรับเมนู</v-list-item-title>
                    </v-list-item-content>
                </v-list-item> -->
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    อัปโหลดรูปสำหรับเมนู
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="12">
                            <uploadImageMultiple
                                :propUploadImange="uploadImange"
                                @emitImagesId="emitImagesId"
                                @emitRemoveImage="emitRemoveImage"
                            ></uploadImageMultiple>
                        </v-col>

                        <cardImageThumbnailPathSize800ForImageForMenu
                            v-for="(
                                image_for_menu, index
                            ) in propOrderDetail.image_for_menus"
                            :key="index"
                            :path="image_for_menu.google_image.src_name"
                            :propImageForMenu="image_for_menu"
                        ></cardImageThumbnailPathSize800ForImageForMenu>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import uploadImageMultiple from "@/js/components/google/drive/uploadImageMultiple";
import cardImageThumbnailPathSize800ForImageForMenu from "@/js/components/google/drive/cardImageThumbnailPathSize800ForImageForMenus";
export default {
    props: ["propBlock", "propOrderDetail"],
    components: {
        uploadImageMultiple,
        cardImageThumbnailPathSize800ForImageForMenu,
    },
    data() {
        return {
            dialog: false,
            uploadImange: this.propOrderDetail.product_prototypes,
        };
    },
    methods: {
        async emitImagesId(v) {
            const payload = {
                order_detail_id: this.propOrderDetail.id,
                img: v,
            };
            const result = await this.$store.dispatch(
                "orderImageForMenu/store",
                payload
            );

            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.$route.params.id,
                });
                // this.$toast.success("อัปโหลดสำเร็จ");
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
            }
        },
        async emitRemoveImage(v) {
            let loader = this.$loading.show();
            const payload = {
                order_detail_id: this.propOrderDetail.id,
                img: v,
            };
            const result = await this.$store.dispatch(
                "orderImageForMenu/delete",
                payload
            );

            if (result.status == 200) {
                const findUploadImange = this.uploadImange.find((e) => {
                    return e.id == v;
                });

                const index = this.uploadImange.indexOf(findUploadImange);

                this.uploadImange.splice(index, 1);
                this.$toast.success("ลบรูปภาพสำเร็จ");
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
            }

            loader.hide();
        },
        exit() {
            this.dialog = false;
        },
    },
};
</script>
