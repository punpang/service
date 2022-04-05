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
                    <div>อัปโหลดรูปต้นแบบสินค้า</div>
                </v-btn> -->
                <v-list-item v-on="on">
                    <v-list-item-icon>
                        <v-icon>attach_file</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="py-2">อัปโหลดรูปต้นแบบสินค้า</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    อัปโหลดรูปต้นแบบสินค้า
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

                        <cardImageThumbnailPathSize800ForProductPrototype
                            v-for="(
                                product_prototype, index
                            ) in propOrderDetail.product_prototypes"
                            :key="index"
                            :path="product_prototype.google_image.src_name"
                            :proppProductPrototype="product_prototype"
                        ></cardImageThumbnailPathSize800ForProductPrototype>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import uploadImageMultiple from "@/js/components/google/drive/uploadImageMultiple";
import cardImageThumbnailPathSize800ForProductPrototype from "@/js/components/google/drive/cardImageThumbnailPathSize800ForProductPrototype";
export default {
    props: ["propBlock", "propOrderDetail"],
    components: {
        uploadImageMultiple,
        cardImageThumbnailPathSize800ForProductPrototype,
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
                "orderProductPrototype/store",
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
                "orderProductPrototype/delete",
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
