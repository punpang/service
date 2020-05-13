<template>
    <div>
        <v-dialog v-model="dialog" persistent width="800">
            <template v-slot:activator="{ on }">
                <v-btn color="primary" class="mr-2 d-none d-sm-flex" v-on="on">
                    <v-icon left>link</v-icon>
                    ส่งลิงก์อัปโหลดรูป
                </v-btn>
                <v-btn
                    color="primary"
                    class="mr-2 d-flex d-sm-none"
                    fab
                    v-on="on"
                >
                    <v-icon left>link</v-icon>
                    <!-- ส่งลิงก์อัปโหลดรูป -->
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    >ส่งลิงก์อัปโหลดรูป
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <sentLinkForUploadImage
                        :detail="detail"
                    ></sentLinkForUploadImage>

                    <sentLinkExampleImage
                        :detail="detail"
                        v-if="detail.upload_image.example"
                    ></sentLinkExampleImage>
                    <v-divider></v-divider>

                    <v-row>
                        <v-col cols="12" md="8">
                            <h5>รูปภาพต้นแบบสินค้า</h5>
                            <v-row>
                                <v-col
                                    cols="6"
                                    md="6"
                                    v-for="image in detail.upload_image.images"
                                    :key="image.id"
                                >
                                    <v-img
                                        :src="image.url"
                                        :lazy-src="image.url"
                                        aspect-ratio="1"
                                    >
                                        <v-btn
                                            color="cyan"
                                            class="ma-2"
                                            fab
                                            small
                                        >
                                            <v-icon>cloud_download</v-icon>
                                        </v-btn>
                                        <v-btn
                                            color="teal"
                                            fab
                                            small
                                            v-clipboard:copy="image.url_full"
                                            v-clipboard:success="onCopyUrlFull"
                                        >
                                            <v-icon>link</v-icon>
                                        </v-btn>

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
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import sentLinkForUploadImage from "@/js/components/orders/details/sentLinkForUploadImage";
import sentLinkExampleImage from "@/js/components/orders/details/sentLinkExampleImage";
sentLinkExampleImage;
export default {
    props: ["detail"],
    components: {
        sentLinkForUploadImage,
        sentLinkExampleImage
    },
    data() {
        return {
            dialog: false
        };
    },
    methods: {
        onCopyUrlFull() {
            this.$toast.success("คัดลอกลิงก์รูปภาพสำเร็จ");
        }
    }
};
</script>

<style></style>
