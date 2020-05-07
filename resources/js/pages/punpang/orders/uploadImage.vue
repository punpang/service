<template>
    <div>
        <v-alert type="error" v-if="!response.data.success">
            {{ response.data.message }}
        </v-alert>
        <v-row v-else>
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>รูปภาพต้นแบบสินค้า</v-card-title>
                    <v-card-text>
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
                        <v-img :src="previewExample" class="mb-4"> </v-img>
                        {{ response.data }}
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>รูปภาพต้นแบบสินค้า</v-card-title>
                    <v-card-text>
                        <v-file-input
                            multiple
                            outlined
                            prepend-icon="image"
                            placeholder="รูปภาพต้นแบบสินค้า"
                            accept="image/*"
                            @change="onFileChangeImages"
                            hide-details
                            :rules="[v => !!v]"
                            class="mb-4"
                        ></v-file-input>
                        <v-row>
                            <v-col
                                cols="12"
                                md="12"
                                v-for="(image, index) in previewImages"
                                :key="index"
                            >
                                <v-img :src="image">
                                    <v-btn v-if="1==2"
                                        color="error"
                                        class="mt-4 ml-4"
                                        @click="clickRemoveImage(image)"
                                    >
                                        <v-icon left>delete</v-icon>
                                        ลบรูปนี้
                                    </v-btn>
                                </v-img>
                            </v-col>
                        </v-row>

                        {{ response.data }}
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
            previewImages: []
        };
    },
    methods: {
        async start() {
            //this.overlay = true;
            this.token = this.$route.params.token;
            this.response = await axios.get(
                "/api/v1/guest/order/" + this.token + "/uploadImageByToken"
            );
        },
        onFileChangeExample(image) {
            this.slipFile = event.target.files[0];
            this.previewExample = URL.createObjectURL(image);
        },
        onFileChangeImages(images) {
            this.previewImages = [];
            for (let i = 0; i < images.length; i++) {
                this.previewImages.push(URL.createObjectURL(images[i]));
            }
        },
        clickRemoveImage(i) {
            console.log(i);            
            this.previewImages.slice(i);
            console.log(this.previewImages);
        }
    },
    mounted() {
        this.start();
    }
};
</script>

<style></style>
