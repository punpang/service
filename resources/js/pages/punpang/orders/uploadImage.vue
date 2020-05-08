<template>
    <div>
        <v-alert type="error" v-if="!response.success">
            {{ response.message }}
        </v-alert>
        <v-row v-else>
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>รูปภาพต้นแบบสินค้า</v-card-title>
                    <v-card-text v-if="response.data.example">
                        <div v-if="!response.data.example_image">
                            <v-file-input
                                outlined
                                prepend-icon="image"
                                placeholder="รูปภาพต้นแบบสินค้า"
                                accept="image/*"
                                @change="onFileChangeExample"
                                hide-details
                                :rules="[v => !!v]"
                                class="mb-4"
                            ></v-file-input>
                            <v-alert type="info">โปรดอัปโหลดรูป</v-alert>
                        </div>

                        <v-img
                            :src="response.data.example_image.url"
                            class="mb-4"
                            v-else
                        >
                            <v-btn
                                color="error"
                                class="mt-4 ml-4"
                                @click="
                                    clickRemoveImage(
                                        response.data.example_image.id
                                    )
                                "
                            >
                                <v-icon left>delete</v-icon>
                                ลบรูปนี้
                            </v-btn>
                        </v-img>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-alert type="warning"
                            >คุณไม่มีสิทธิ์อัปโหลดส่วนนี้</v-alert
                        >
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>รูปสำหรับทำสินค้า</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="9">
                                <v-text-field
                                    label="เขียนข้อความ"
                                    outlined
                                    hide-details
                                    v-model="form.write"
                                    prepend-icon="edit"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-btn
                                    color="success"
                                    block
                                    class="mt-2"
                                    @click="clickSubmitUpdateWrite"
                                    :disabled="
                                        form.write ==
                                            response.data.order_detail.write ||
                                            form.write == ''
                                    "
                                >
                                    <v-icon left>save</v-icon>
                                    บันทึก
                                </v-btn>
                            </v-col>
                        </v-row>

                        <v-divider></v-divider>
                        <v-form ref="formInputImages">
                            <v-file-input
                                multiple
                                outlined
                                prepend-icon="image"
                                placeholder="เลือกรูปที่นี่"
                                accept="image/*"
                                @change="onFileChangeImages"
                                hide-details
                                class="mb-4"
                            ></v-file-input>
                        </v-form>

                        <v-row>
                            <v-col
                                cols="12"
                                md="12"
                                v-for="image in response.data.image"
                                :key="image.id"
                            >
                                <v-img :src="image.url">
                                    <v-btn
                                        color="primary"
                                        class="mt-2 ml-2"
                                        @click="clickRemoveImage(image.id)"
                                    >
                                        <v-icon left>bookmark</v-icon>
                                        ตั้งเป็นรูปหลัก
                                    </v-btn>
                                    <v-btn
                                        color="error"
                                        class="mt-2 ml-2"
                                        @click="clickRemoveImage(image.id)"
                                    >
                                        <v-icon left>delete</v-icon>
                                        ลบรูปนี้
                                    </v-btn>
                                </v-img>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            response: {
                data: {
                    success: true
                }
            },
            previewExample: "",
            previewImages: [],
            form: {
                write: ""
            },
        };
    },
    methods: {
        async start() {
            let loader = this.$loading.show();

            this.token = this.$route.params.token;
            const { data } = await axios.get(
                "/api/v1/guest/order/" + this.token + "/uploadImageByToken"
            );
            this.response = data;
            this.form.write = data.data.order_detail.write;

            loader.hide();
        },
        async onFileChangeExample(image) {
            let loader = this.$loading.show();
            const exampleFile = event.target.files[0];
            const formData = new FormData();
            formData.append("image", exampleFile);

            const res = await axios.post(
                "/api/v1/guest/order/" +
                    this.token +
                    "/uploadImageByToken/example",
                formData
            );
            loader.hide();
            await this.start();
            this.toast(res);
        },
        async onFileChangeImages(images) {
            let loader = this.$loading.show();
            const Images = event.target.files;
            const formData = new FormData();
            for (let i = 0; i < images.length; i++) {
                formData.append("image", Images[i]);
                let res = await axios.post(
                    "/api/v1/guest/order/" +
                        this.token +
                        "/uploadImageByToken/images",
                    formData
                );
            }
            loader.hide();
            await this.start();
            this.toast(res);
            this.$refs.formInputImages.reset();
        },
        onFileChangeImagesV1(images) {
            this.previewImages = [];
            for (let i = 0; i < images.length; i++) {
                this.previewImages.push(URL.createObjectURL(images[i]));
            }
        },
        async clickRemoveImage(id) {
            let loader = this.$loading.show();
            const res = await axios.delete(
                "/api/v1/guest/order/" +
                    this.token +
                    "/uploadImageByToken/" +
                    id +
                    "/delete"
            );
            loader.hide();
            await this.start();
            this.toast(res);
        },
        async clickSubmitUpdateWrite() {
            let loader = this.$loading.show();
            const res = await axios.post(
                "/api/v1/guest/order/" + this.token + "/updateWrite",
                this.form
            );
            loader.hide();
            await this.start();
            this.toast(res);
        },
        toast(res) {
            if (res.status === 200) {
                if (res.data.success) {
                    this.$toast.success(res.data.message);
                } else {
                    this.$toast.error(res.data.message);
                }
            } else {
                this.$toast.error(
                    "เกิดข้อผิดพลาดบางอย่างขึ้น กรุณาลองอีกครั้ง"
                );
            }
        }
    },
    async mounted() {
        await this.start();
    }
};
</script>

<style></style>
