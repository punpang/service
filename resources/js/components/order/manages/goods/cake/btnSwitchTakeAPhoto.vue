<template>
    <div>
        <v-switch
            label="ถ่ายรูปสินค้า"
            hide-details
            class="my-3"
            v-model="propOrderDetail.is_take_a_photo"
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
                is_take_a_photo: this.propOrderDetail.is_take_a_photo,
            };

            const result = await this.$store.dispatch(
                "orderIndex/switchIsTakeAPhoto",
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
