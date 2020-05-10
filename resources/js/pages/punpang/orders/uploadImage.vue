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
                    <v-card-title>รูปภาพสำหรับทำสินค้า</v-card-title>
                    <v-card-text v-if="response.data.image">
                        <v-text-field
                            label="เขียนข้อความ"
                            outlined
                            hide-details
                            v-model="form.write"
                            prepend-icon="edit"
                        ></v-text-field>
                        <v-btn
                            large
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
                        <div v-if="response.data.images.length > 1">
                            <div
                                v-if="
                                    response.data.images.length > 1 &&
                                        !chooseRemove
                                "
                            >
                                <v-btn
                                    class="mb-2"
                                    color="warning"
                                    @click="chooseRemove = true"
                                >
                                    <v-icon left>delete</v-icon>
                                    เลือกรูปที่ต้องการลบ</v-btn
                                >
                            </div>
                            <div v-else>
                                <v-btn
                                    class="mb-2"
                                    color="error"
                                    @click="
                                        clickRemoveImage(chooseRemoveImages)
                                    "
                                    :disabled="chooseRemoveImages.length == 0"
                                >
                                    <v-icon left>delete</v-icon>
                                    ลบรูปที่เลือกไว้</v-btn
                                >

                                <v-btn
                                    color="error"
                                    class="mb-2"
                                    @click="
                                        clickRemoveImage(response.data.images)
                                    "
                                >
                                    <v-icon left>delete</v-icon>
                                    ลบรูปทั้งหมด</v-btn
                                >

                                <v-btn
                                    color="warning"
                                    class="mb-2"
                                    @click="clickRemoveImageCancel"
                                >
                                    <v-icon left>close</v-icon>
                                    ยกเลิก</v-btn
                                >
                            </div>
                        </div>

                        <v-divider class="mb-1 mt-2"></v-divider>

                        <v-alert
                            type="info"
                            v-if="response.data.images.length == 0"
                            >โปรดอัปโหลดรูป</v-alert
                        >
                        <v-row>
                            <v-col
                                cols="12"
                                md="12"
                                v-for="image in response.data.images"
                                :key="image.id"
                            >
                                <v-checkbox
                                    v-model="chooseRemoveImages"
                                    v-if="chooseRemove"
                                    label="ลบรูปนี้"
                                    hide-details
                                    class="ma-0"
                                    :value="image"
                                ></v-checkbox>
                                <v-img :src="image.url" :lazy-src="image.url">
                                    <div v-if="!chooseRemove">
                                        <v-btn
                                            color="warning"
                                            class="mt-2 ml-2"
                                            v-if="image.main"
                                            @click="clickImageMain(image.id)"
                                        >
                                            <v-icon left>bookmark</v-icon>
                                            ยกเลิกรูปหลัก
                                        </v-btn>
                                        <v-btn
                                            color="primary"
                                            class="mt-2 ml-2"
                                            v-else
                                            @click="clickImageMain(image.id)"
                                        >
                                            <v-icon left>bookmark</v-icon>
                                            ตั้งเป็นรูปหลัก
                                        </v-btn>

                                        <v-btn
                                            color="error"
                                            class="mt-2 ml-2"
                                            @click="clickRemoveImage([image])"
                                        >
                                            <v-icon left>delete</v-icon>
                                            ลบรูปนี้
                                        </v-btn>
                                    </div>
                                    <template v-slot:placeholder>
                                        <v-row
                                            class="fill-height ma-0"
                                            align="center"
                                            justify="center"
                                        >
                                            <v-progress-circular
                                                indeterminate
                                                color="grey lighten-5"
                                            ></v-progress-circular>
                                        </v-row>
                                    </template>
                                </v-img>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-alert type="warning"
                            >คุณไม่มีสิทธิ์อัปโหลดส่วนนี้</v-alert
                        >
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
            chooseRemove: false,
            previewExample: "",
            previewImages: [],
            form: {
                write: ""
            },
            chooseRemoveImages: []
        };
    },
    methods: {
        async start() {
            this.token = this.$route.params.token;
            const { data } = await axios.get(
                "/api/v1/guest/order/" + this.token + "/uploadImageByToken"
            );
            this.response = data;
            this.form.write = data.data.order_detail.write;
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
            await this.start();
            loader.hide();
            this.toast(res);
        },
        async onFileChangeImages(images) {
            let loader = this.$loading.show();
            const Images = event.target.files;
            const formData = new FormData();
            this.$toast.warning("กำลังอัปโหลดรูป " + images.length + " รูป");
            let res = {};
            for (let i = 0; i < images.length; i++) {
                formData.append("image", Images[i]);
                res = await axios.post(
                    "/api/v1/guest/order/" +
                        this.token +
                        "/uploadImageByToken/images",
                    formData
                );
                if (res.data.success) {
                    this.$toast.success(
                        res.data.message +
                            " " +
                            (i + 1) +
                            "/" +
                            images.length +
                            " รูป"
                    );
                } else {
                    i = images.length;
                    this.$toast.error("คุณไม่มีสิทธิ์อัปโหลดส่วนนี้");
                }
            }

            await this.start();
            loader.hide();

            //this.toast(res);
        },
        async clickRemoveImage(images) {
            let loader = this.$loading.show();
            let res = {};
            this.$toast.warning("กำลังลบรูปภาพ " + images.length + " รูป");
            for (let index = 0; index < images.length; index++) {
                res = await axios.delete(
                    "/api/v1/guest/order/" +
                        this.token +
                        "/uploadImageByToken/" +
                        images[index].id +
                        "/delete"
                );
                if (res.data.success) {
                    this.$toast.success(
                        res.data.message +
                            " " +
                            (index + 1) +
                            "/" +
                            images.length +
                            " รูป"
                    );
                } else {
                    index = images.length;
                    this.$toast.error("คุณไม่มีสิทธิ์อัปโหลดส่วนนี้");
                }
            }
            this.clickRemoveImageCancel();
            await this.start();
            loader.hide();
        },
        async clickImageMain(image_id) {
            let loader = this.$loading.show();
            const res = await axios.post(
                "/api/v1/guest/order/" +
                    this.token +
                    "/uploadImageByToken/" +
                    image_id +
                    "/ImageMain"
            );
            await this.start();
            loader.hide();
            this.toast(res);
        },
        async clickSubmitUpdateWrite() {
            let loader = this.$loading.show();
            const res = await axios.post(
                "/api/v1/guest/order/" + this.token + "/updateWrite",
                this.form
            );
            await this.start();
            loader.hide();
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
        },
        clickRemoveImageCancel() {
            this.chooseRemove = false;
            this.chooseRemoveImages = [];
        }
    },
    async mounted() {
        let loader = this.$loading.show();
        await this.start();
        loader.hide();
    }
};
</script>

<style></style>
