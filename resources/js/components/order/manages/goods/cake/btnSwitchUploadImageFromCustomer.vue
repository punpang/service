<template>
    <div>
        <v-switch
            label="อัปโหลดรูปภาพ"
            hide-details
            class="my-3"
            v-model="propOrderDetail.status_upload_images_from_customer"
            @click="clickSwitch(propOrderDetail.id)"
        >
        </v-switch>
    </div>
</template>

<script>
export default {
    props: ["propOrderDetail"],
    data() {
        return {};
    },
    methods: {
        async clickSwitch(order_detail_id) {
            let loader = this.$loading.show();
            const payload = {
                order_detail_id: order_detail_id,
                status_upload_images_from_customer:
                    this.propOrderDetail.status_upload_images_from_customer,
            };

            const result = await this.$store.dispatch(
                "orderIndex/switchStatusUploadImagesFromCustomer",
                payload
            );

            if (result.status == 200) {
                this.$toast.success("เปลี่ยนแปลงเรียบร้อย");
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
            }
            loader.hide();
        },
    },
};
</script>
