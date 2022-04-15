<template>
    <div>
        <v-card outlined v-if="order.order_delivery_service">
            <v-card-title class="text-h6 white--text info">
                บริการจัดส่ง
                <v-spacer></v-spacer>
                <v-btn fab icon x-small class="white--text">
                    <v-icon>more_horiz</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pa-4">
                <div>
                    <strong>ชื่อผู้รับ</strong>
                    <strong class="text-subtitle-1">{{
                        order.order_delivery_service.recipient_name
                    }}</strong>
                </div>
                <div>
                    <strong>เบอร์โทรผู้รับ</strong>
                    <strong class="text-subtitle-1">
                        {{ order.order_delivery_service.recipient_phone }}
                    </strong>
                </div>
                <div>
                    <strong>ค่าบริการจัดส่ง</strong>
                    <strong class="text-subtitle-1"
                        >{{
                            order.order_delivery_service.delivery_fee
                        }}
                        บาท</strong
                    >
                </div>
                <div v-if="order.order_delivery_service.detail">
                    <strong>หมายเหตุ</strong>
                    <strong class="text-subtitle-1">{{
                        order.order_delivery_service.detail
                    }}</strong>
                </div>
                <v-btn
                    small
                    class="info"
                    :href="order.order_delivery_service.link_google_maps"
                >
                    <v-icon left>location_on</v-icon>
                    Link Google Map</v-btn
                >
                <v-divider></v-divider>
                <v-btn class="success">
                    <v-icon left>local_shipping</v-icon>
                    ทำการจัดส่ง</v-btn
                >
                <v-btn class="error" @click="clickRemove()">
                    <v-icon left>delete</v-icon>
                    ลบ</v-btn
                >
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    methods: {
        clickRemove() {
            this.$swal({
                icon: "warning",
                title: "คำเตือน",
                text: "ต้องการลบบริการจัดส่งใช่ไหม",
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ต้องการลบ",
                cancelButtonText: "ไม่ต้องการลบ",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.processingRemove();
                }
            });
        },
        async processingRemove() {
            console.log(this.order.order_delivery_service.id);

            // let loader = this.$loading.show();

            const result = await this.$store.dispatch(
                "orderDeliveryService/remove",
                {
                    delivery_service_id: this.order.order_delivery_service.id,
                }
            );
            if (result.status == 200) {
                this.$toast.success(result.data.message);
                // let loader = this.$loading.show();
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.order.id,
                });
                this.exit();
                // loader.hide();
            } else {
                this.$toast.error(result.data.message);
            }

            // loader.hide();
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
