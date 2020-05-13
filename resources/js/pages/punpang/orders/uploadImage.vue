<template>
    <div>
        <div v-if="response.success == null">
            <v-alert type="info">
                กำลังโหลดข้อมูล...รอสักครู่ค่ะ
            </v-alert>
        </div>
        <div v-else-if="!response.success && response.success != null">
            <v-alert type="error">
                {{ response.message }}
            </v-alert>
            <h5>สาเหตุที่อาจเป็นไปได้</h5>
            <v-divider></v-divider>
            <p class="title ">
                คุณอาจไม่มีสิทธิ์การเข้าถึงเว็ปไซต์นี้แล้ว
                เนื่องจากสาเหตุดังต่อไปนี้
            </p>
            <p class="subtitle-2 mb-2">- ลิงก์เว็บอาจผิด</p>
            <p class="subtitle-2 mb-2">- รายการสั่งซื้อนี้ อาจถูกยกเลิกแล้ว</p>
            <p class="subtitle-2 mb-2">
                - รายการสั่งซื้อนี้ อาจเลยวันรับสินค้าไปแล้ว
            </p>
            <p class="subtitle-2 mb-2">
                - รายการสั่งซื้อนี้ อาจไม่มีสิทธิ์เข้าถึงการอัปโหลดรูปอีกต่อไป
            </p>
            <v-divider></v-divider>
            <h5>ช่องทางติดต่อทางร้าน</h5>
            <v-divider></v-divider>
            <v-btn color="primary" href="http://m.me/punpangpranburi"
                >Facebook</v-btn
            >

            <v-btn
                color="success"
                :disabled="true"
                href="http://m.me/punpangpranburi"
                >Line</v-btn
            >
        </div>

        <v-row v-else>
            <v-col cols="12" md="6" class="pb-0">
                <h5>ข้อมูลรายการสั่งซื้อ</h5>
                <v-divider></v-divider>
                <OrderDetail
                    :order="response.data.order_detail.order"
                ></OrderDetail>
                <v-divider></v-divider>
                <h5>ข้อมูลสินค้า</h5>
                <v-divider class="mb-0"></v-divider>
                <productDetail
                    :detail="response.data.order_detail"
                ></productDetail>
                <v-divider class="my-0"></v-divider>
            </v-col>

            <v-col cols="12" md="6">
                <div v-if="response.data.example" class="mb-4">
                    <h5>รูปภาพต้นแบบสินค้า</h5>
                    <v-divider></v-divider>
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
                                clickRemoveImage([response.data.example_image])
                            "
                        >
                            <v-icon left>delete</v-icon>
                            ลบรูปนี้
                        </v-btn>
                    </v-img>
                    <v-divider></v-divider>
                </div>
                <div v-if="response.data.image">
                    <h5>รูปภาพสำหรับทำสินค้า</h5>
                    <v-divider></v-divider>
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
                            form.write == response.data.order_detail.write ||
                                form.write == ''
                        "
                    >
                        <v-icon left>save</v-icon>
                        บันทึกข้อความ
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
                                response.data.images.length > 1 && !chooseRemove
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
                                @click="clickRemoveImage(chooseRemoveImages)"
                                :disabled="chooseRemoveImages.length == 0"
                            >
                                <v-icon left>delete</v-icon>
                                ลบรูปที่เลือกไว้</v-btn
                            >

                            <v-btn
                                color="error"
                                class="mb-2"
                                @click="clickRemoveImage(response.data.images)"
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

                    <v-alert type="info" v-if="response.data.images.length == 0"
                        >โปรดอัปโหลดรูป</v-alert
                    >
                    <v-card
                        outlined
                        v-for="image in response.data.images"
                        :key="image.id"
                        class="mb-2"
                    >
                        <v-img :src="image.url" :lazy-src="image.url">
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
                        <v-card-text class="pa-2">
                            <v-checkbox
                                v-model="chooseRemoveImages"
                                v-if="chooseRemove"
                                label="ลบรูปนี้"
                                hide-details
                                class="ma-0"
                                :value="image"
                            ></v-checkbox>
                            <div v-else class="mt-2">
                                <v-btn
                                    color="warning"
                                    v-if="image.main"
                                    @click="clickImageMain(image.id)"
                                    text
                                >
                                    <v-icon left>bookmark_border</v-icon>
                                    ยกเลิกรูปหลัก
                                </v-btn>
                                <v-btn
                                    color="primary"
                                    v-else
                                    @click="clickImageMain(image.id)"
                                    text
                                >
                                    <v-icon left>bookmark</v-icon>
                                    ตั้งเป็นรูปหลัก
                                </v-btn>

                                <v-btn
                                    color="error"
                                    @click="clickRemoveImage([image])"
                                    text
                                >
                                    <v-icon left>delete</v-icon>
                                    ลบรูปนี้
                                </v-btn>
                            </div>
                        </v-card-text>
                    </v-card>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import OrderDetail from "@/js/components/orders/details/detailNotFB";
import productDetail from "@/js/components/orders/details/productDetail";

export default {
    components: {
        OrderDetail,
        productDetail
    },
    data() {
        return {
            response: {
                data: {
                    success: null
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
            const res = await axios.get(
                "/api/v1/guest/order/" + this.token + "/uploadImageByToken"
            );
            if (res.status === 200) {
                if (res.data.success) {
                    this.form.write = res.data.data.order_detail.write;
                }
                this.response = res.data;
            }
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
