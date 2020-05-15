<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" color="cyan" class="d-none d-sm-flex">
                    <v-icon left>
                        insert_photo
                    </v-icon>
                    อัปโหลดรูปสินค้า
                </v-btn>

                <v-btn v-on="on" color="cyan" fab small class="d-fex d-sm-none">
                    <v-icon>
                        insert_photo
                    </v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    อัปโหลดรูปสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-divider class="ma-0"></v-divider>
                <v-card-text>
                    <v-file-input
                        outlined
                        hide-details
                        label="รูปภาพสินค้าสำเร็จรูป"
                        placeholder="เลือกรูปที่นี่"
                        :rules="[v => !!v]"
                        prepend-icon="image"
                        accept="image/*"
                        class="my-4"
                        @change="changeUploadFinishedProductImage"
                    ></v-file-input>
                    <imageThumbnailPathSize800
                        v-if="detail.finished_product_image != null"
                        :path="detail.finished_product_image"
                    ></imageThumbnailPathSize800>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
export default {
    props: ["detail"],
    components: {
        imageThumbnailPathSize800
    },
    data() {
        return {
            dialog: false,
            imageProduct: {}
        };
    },
    methods: {
        async changeUploadFinishedProductImage() {
            let loader = this.$loading.show()
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append("image", file);
            const form = {
                detail_id: this.detail.id,
                formData
            };
            const res = await this.$store.dispatch(
                "orderDetail/uploadFinishedProductImage",
                form
            );           

            if(res.status === 200){
                if(res.data.success){
                    this.$toast.success(res.data.message)
                }
            }else{
                this.$toast.error("เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง")
            }
            await this.$store.dispatch("order/getByID", this.detail.order_id);
            loader.hide()
        }
    }
};
</script>

<style></style>
