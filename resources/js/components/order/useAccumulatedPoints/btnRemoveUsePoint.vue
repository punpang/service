<template>
    <v-btn icon fab x-small @click="removeUsePoint()"
        ><v-icon color="error">cancel</v-icon></v-btn
    >
</template>

<script>
import { mapGetters } from "vuex";
export default {
    methods: {
        async getData() {
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });
            loader.hide();
        },
        async removeUsePoint() {
            let loader = this.$loading.show();
            const result = await this.$store.dispatch(
                "orderIndex/remove_use_point_by_order_id",
                { order_id: this.order.id }
            );

            if (result.status == 200) {
                this.$toast.success(result.data.text);
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
            }

            await this.getData();
            loader.hide();
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
