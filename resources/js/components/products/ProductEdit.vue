<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="600"
            persistent
            transition="dialog-bottom-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn color="warning" v-on="on" fab x-small>
                    <v-icon>edit</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    >แก้ไขสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-form ref="formUpdate" lazy-validation>
                        <v-text-field
                            label="ชื่อสินค้า"
                            counter="100"
                            v-model="form.name"
                            :rules="Rules.name"
                        ></v-text-field>

                        <v-row>
                            <v-col cols="12" md="6">
                                <v-switch
                                    v-model="form.status"
                                    inset
                                    label="สถานะการใช้งาน"
                                ></v-switch>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-switch
                                    v-model="form.product_show"
                                    inset
                                    label="แสดงสินค้าบนหน้าเว็ปไซต์"
                                ></v-switch>
                            </v-col>
                        </v-row>

                        <v-text-field
                            label="ราคาปกติ"
                            counter="10"
                            type="number"
                            pattern="\d*"
                            suffix="บาท"
                            v-model="form.price_normal"
                            :rules="Rules.price_normal"
                        ></v-text-field>

                        <v-switch
                            v-model="form.price_special_status"
                            inset
                            label="ราคาพิเศษ"
                            @change="changePriceSpecialStatus"
                        ></v-switch>
                        <v-text-field
                            label="ราคาพิเศษ"
                            counter="10"
                            type="number"
                            pattern="\d*"
                            suffix="บาท"
                            v-show="form.price_special_status == true"
                            v-model="form.price_special"
                            :rules="Rules.price_special"
                        ></v-text-field>

                        <v-switch
                            v-model="form.image_status"
                            inset
                            label="อัปโหลดรูป"
                            @change="changeImageStatus"
                        ></v-switch>
                        <v-file-input
                            label="อัปโหลดรูป"
                            v-model="file"
                            v-show="form.image_status == true && !imagePreview"
                            prepend-icon="image"
                            @change="changeImage"
                            accept="image/*"
                        >
                        </v-file-input>
                        <v-btn
                            color="info"
                            @click="clickUploadImage"
                            v-show="form.image_status == true && !imagePreview"
                            :loading="loadUploadImage"
                        >
                            <v-icon left>cloud_upload</v-icon>
                            อัปโหลดรูปภาพ
                        </v-btn>
                        <v-btn
                            color="error"
                            @click="clickRemoveImage"
                            v-show="imagePreview && form.image_status == true"
                            :loading="loadUploadImage"
                        >
                            <v-icon left>delete</v-icon>
                            ลบรูปภาพ
                        </v-btn>
                        <v-row>
                            <v-col
                                cols="12"
                                md="6"
                                v-show="
                                    form.image_status == true && imagePreview
                                "
                            >
                                <v-card>
                                    <v-img
                                        :src="
                                            'https://drive.google.com/thumbnail?id=' +
                                                imagePreview
                                        "
                                    ></v-img>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="success" @click="save" :loading="loading">
                        <v-icon left>save</v-icon>
                        แก้ไขข้อมูลสินค้า
                    </v-btn>
                    <v-btn color="error" @click="reset">
                        <v-icon left>clear</v-icon>
                        ล้างข้อมูล
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-overlay :value="overlay">
                <v-progress-circular
                    indeterminate
                    :size="this.$store.getters['main/sizeOverlay']"
                ></v-progress-circular>
            </v-overlay>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            overlay: false,
            dialog: false,
            loading: false,
            file: {},
            image: "",
            imagePreview: this.data.product_image.src_name,
            loadUploadImage: false,
            form: this.data,
            formDefault: {
                name: "",
                price_normal: "",
                price_special_status: true,
                price_special: "",
                status: "1",
                image_status: true,
                product_image_id: "1",
                product_show: 1
            },
            Rules: {
                name: [
                    v => !!v || "ห้ามเว้นว่าง",
                    v => v.length <= 100 || "ไม่เกิน 100 ตัวอักษร"
                ],
                price_normal: [
                    v => !!v || "ห้ามเว้นว่าง",
                    v => 0 > v.length <= 10 || "ไม่เกิน 10 ตัวอักษร"
                ],
                price_special: [
                    v => !!v || "ห้ามเว้นว่าง",
                    v => 0 > v.length <= 10 || "ไม่เกิน 10 ตัวอักษร"
                ],
                image: [v => !!v || "ห้ามเว้นว่าง"]
            },
        };
    },
    methods: {
        changeImage() {
            this.image = event.target.files[0];
        },
        async clickUploadImage() {
            this.loadUploadImage = true;
            this.overlay = true;
            const formData = new FormData();
            formData.append("image", this.image);
            const response = await this.$store.dispatch("productImage/update", {
                id: this.data.id,
                formData
            });
            if (response.status == 200) {
                this.imagePreview = response.data.src_name;
                this.$toast.success("อัปโหลดรูปสำเร็จ")
                this.form.product_image_id = response.data.id;
                this.loadUploadImage = false;
                this.overlay = false;
            } else {
                this.$toast.error("อัปโหลดรูปไม่สำเร็จ เกิดข้อผิดพลาดบางอย่าง")
                this.loadUploadImage = false;
                this.overlay = false;
            }
        },
        async clickRemoveImage() {
            this.overlay = true;
            const response = await this.$store.dispatch(
                "productImage/destroy",
                this.form.product_image_id
            );

            if (response.status == 200) {
                this.imagePreview = "";
                this.$toast.success("ลบรูปภาพสำเร็จ")
                this.form.product_image_id = "1";
                this.overlay = false;
            } else {
                this.snackbarError();
                this.overlay = false;
            }
        },
        changePriceSpecialStatus(value) {
            if (value === false && this.form.price_special === "") {
                if (this.form.price_normal > 0) {
                    this.form.price_special = this.form.price_normal;
                } else {
                    this.form.price_special = "999.99";
                }
            }
        },
        changeImageStatus(value) {
            if (value == false && this.file == "") {
                this.file = "image.jpg";
            } else if (value == true && this.file == "image.jpg") {
                this.file = "";
            }
        },
        snackbarError() {
            this.$toast.error("เกิดข้อผิดพลาดบางอย่าง ลองอีกครั้งภายหลัง")
        },
        async save() {
            if (this.$refs.formUpdate.validate()) {
                this.loading = true;
                this.overlay = true;
                const response = await this.$store.dispatch(
                    "product/update",
                    this.form
                );
                if (response.status == 200) {
                    this.loading = false;
                    this.$toast.success("เพิ่มสินค้าใหม่สำเร็จ")
                    this.dialog = false;
                    this.overlay = false;
                }
            } else {
                this.$toast.warning("คุณอาจกรอกไม่ครบหรือไม่ถูกต้อง")
                this.overlay = false;
            }
        },
        reset() {
            this.$toast.success("ล้างข้อมูลสำเร็จ")
            this.form.name = "";
        }
    }
};
</script>

<style></style>
