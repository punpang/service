<template>
    <v-col cols="12" md="4" class="pa-1">
        <v-card>
            <imageThumbnailPathSize800 :path="path"></imageThumbnailPathSize800>

            <v-card-actions>
                <v-btn
                    v-if="user.type == 1"
                    :href="
                        'https://drive.google.com/uc?id=' +
                        path +
                        '&export=download'
                    "
                    class="white"
                    style="text-decoration: none"
                    elevation="0"
                >
                    <v-icon>file_download</v-icon>ดาวน์โหลด</v-btn
                >
                <v-btn
                    class="white error--text"
                    style="text-decoration: none"
                    elevation="0"
                    @click="clickRemove(propImageFormCustomer)"
                >
                    <v-icon color="error">delete</v-icon>ลบรูปภาพ</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-col>
</template>

<script>
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
import { mapGetters } from "vuex";
export default {
    props: ["path", "propImageFormCustomer"],
    components: { imageThumbnailPathSize800 },
    data() {
        return {
            base: "https://drive.google.com/uc?id=${}&export=download",
        };
    },
    methods: {
        async clickRemove(image) {
            let loader = this.$loading.show();
            const payload = {
                uuid: this.$route.params.uuid,
                order_detail_id: image.order_detail_id,
                image_from_customer_id: image.id,
            };
            const result = await this.$store.dispatch(
                "orderGuestUuid/removeImageIdByUUID",
                payload
            );

            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByUUID", {
                    uuid: this.$route.params.uuid,
                });
                this.$swal({
                    title: "ลบรูปเรียบร้อย",
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            } else {
                this.$swal({
                    title: "เกิดข้อผิดพลาดบางประการ",
                    text: "โปรดลองอีกครั้งภายหลัง",
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                });
            }

            loader.hide();
        },
    },
    computed: {
        ...mapGetters({
            user: "main/User",
        }),
    },
};
</script>
