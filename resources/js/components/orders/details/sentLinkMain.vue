<template>
    <div>
        <v-dialog v-model="dialog" persistent width="800">
            <template v-slot:activator="{ on }">
                <v-btn color="indigo" class="mr-2 d-none d-sm-flex" v-on="on">
                    <v-icon left>link</v-icon>
                    ส่งลิงก์อัปโหลดรูป
                </v-btn>
                <v-btn
                    color="indigo"
                    class="mr-2 d-flex d-sm-none"
                    fab
                    small
                    v-on="on"
                >
                    <v-icon>link</v-icon>
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

                    <h5>รูปภาพต้นแบบสินค้า</h5>
                    <v-row>
                        <v-col
                            cols="12"
                            md="4"
                            v-for="image in detail.upload_image.images"
                            :key="image.id"
                        >
                            <v-card outlined>
                                <v-img
                                    :src="image.url"
                                    :lazy-src="image.url"
                                    aspect-ratio="1"
                                >
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
                                    <v-btn
                                        color="deep-purple"
                                        dark
                                        fab
                                        small
                                        v-if="image.main"
                                    >
                                        <v-icon>star</v-icon>
                                    </v-btn>
                                    <v-btn
                                        color="cyan"
                                        fab
                                        small
                                        @click="clickDownloadImage(image)"
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
                                </v-card-text>
                            </v-card>
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
        },
        forceFileDownload(response, name) {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", name + ".png"); //or any other extension
            document.body.appendChild(link);
            link.click();
        },
        async clickDownloadImage(image) {
            let loader = this.$loading.show();
            await axios({
                method: "get",
                url: image.url_full,
                responseType: "arraybuffer"
            })
                .then(response => {
                    this.forceFileDownload(response, image.public_id);
                })
                .catch(() => console.log("error occured"));
            loader.hide();
        }
    }
};
</script>

<style></style>
