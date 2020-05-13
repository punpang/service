<template>
    <v-dialog v-model="dialog" persistent width="300">
        <template v-slot:activator="{ on }">
            <v-btn color="primary" class="mr-2" v-on="on" @click="clickStart">
                <v-icon left>link</v-icon>
                ส่งลิงก์อัปโหลดรูป
                <!-- ส่งลิงก์อัปโหลดรูป -->
            </v-btn>
        </template>
        <v-card>
            <v-card-title>
                ส่งลิงก์อัปโหลดรูป
                <v-spacer></v-spacer>
                <v-icon color="error" @click="dialog = false">close</v-icon>
            </v-card-title>
            <v-divider class="ma-0"></v-divider>
            <v-card-text>
                <v-checkbox
                    label="รูปภาพตัวอย่างสินค้า"
                    v-model="form.example"
                    hide-details
                    class="mt-4"
                ></v-checkbox>
                <v-checkbox
                    label="รูปภาพสินค้า"
                    v-model="form.image"
                    hide-details
                    class="mt-4"
                ></v-checkbox>
                <v-row class="mt-4 px-4">
                    <v-btn
                        color="success"
                        class="mr-2"
                        @click="clickSubmit"
                        :disabled="form.example == false && form.image == false"
                    >
                        <v-icon left>link</v-icon>
                        ส่งลิงก์</v-btn
                    >
                    <v-btn color="error">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                </v-row>
            </v-card-text>
        </v-card>
        <overlay :overlay="overlay"></overlay>
    </v-dialog>
</template>

<script>
import overlay from "@/js/layouts/overlay";
export default {
    props: ["detail"],
    components: {
        overlay
    },
    data() {
        return {
            dialog: false,
            overlay: false,
            form: {
                example: false,
                image: false
            }
        };
    },
    methods: {
        async clickSubmit() {
            if (this.form.example == false && this.form.image == false) {
                this.$toast.error("ไม่สามารถส่งลิงก์ได้ กรุณาตรวจสอบข้อมูล");
            } else {
                this.overlay = true;
                const payload = {
                    detail_id: this.detail.id,
                    form: this.form
                };
                const res = await this.$store.dispatch(
                    "orderDetail/sentLinkForUploadImage",
                    payload
                );

                if (res.status === 200) {
                    if (res.data.success === true) {
                        this.$toast.success(res.data.message);
                        this.dialog = false;
                    } else {
                        this.$toast.error(res.data.message);
                    }
                    this.overlay = false;
                } else if (res.status === 500) {
                }
            }
        },
        clickStart() {
            if (this.detail.upload_image != null) {
                this.form.example = this.detail.upload_image.example;
                this.form.image = this.detail.upload_image.image;
            }
        }
    }
};
</script>

<style></style>
