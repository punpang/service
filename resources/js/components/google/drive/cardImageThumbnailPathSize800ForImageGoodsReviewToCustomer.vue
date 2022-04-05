<template>
    <v-col cols="12" md="4" class="pa-1">
        <v-card>
            <imageThumbnailPathSize800 :path="path"></imageThumbnailPathSize800>
            <v-card-actions>
                <v-btn
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
                    v-if="user.type === 1"
                    class="white error--text"
                    style="text-decoration: none"
                    elevation="0"
                    @click="clickRemove(propImageGoodsReviewToCustomer)"
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
    props: ["path", "propImageGoodsReviewToCustomer"],
    components: { imageThumbnailPathSize800 },
    data() {
        return {
            base: "https://drive.google.com/uc?id=${}&export=download",
        };
    },
    methods: {
        async clickRemove(prototype) {
            // console.log(this.$route.params.id);
            // return;
            let loader = this.$loading.show();
            const payload = {
                order_detail_id: prototype.order_detail_id,
                image_from_customer_id: prototype.id,
            };
            const result = await this.$store.dispatch(
                "orderImageGoodsReviewToCustomer/delete",
                payload
            );

            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.$route.params.id,
                });
                this.$toast.success("ลบรูปภาพสำเร็จ");
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
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
