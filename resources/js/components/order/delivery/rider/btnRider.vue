<template>
    <div>
        <v-dialog
            width="500"
            scrollable
            persistent
            v-model="dialog"
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    :class="
                        order.order_delivery_service.status == 'create'
                            ? 'success'
                            : 'warning'
                    "
                    @click="clickStart()"
                >
                    <v-icon left>local_shipping</v-icon>

                    ทำการจัดส่ง</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ทำการจัดส่ง
                    <v-spacer></v-spacer>
                    <v-btn fab x-small icon @click="close()">
                        <v-icon class="white--text">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <cardRider :propRider="rider"></cardRider>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        :class="
                            order.order_delivery_service.status == 'create'
                                ? 'success'
                                : 'warning'
                        "
                        @click="saveShipping()"
                    >
                        <v-icon left>local_shipping</v-icon>
                        จัดส่งสินค้า
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardRider from "@/js/components/order/delivery/rider/cardRider";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            dialog: false,
            rider: {
                rider_name: "",
                rider_phone: "",
                rider_remark: "",
                rider_link: "",
                delivery_platform: "",
            },
        };
    },
    components: { cardRider },
    methods: {
        clickStart() {
            if (this.order.order_delivery_service.status == "shipping") {
                this.rider = {
                    rider_name: this.order.order_delivery_service.rider_name,
                    rider_phone: this.order.order_delivery_service.rider_phone,
                    rider_remark:
                        this.order.order_delivery_service.rider_remark,
                    rider_link: this.order.order_delivery_service.rider_link,
                    delivery_platform:
                        this.order.order_delivery_service.delivery_platform,
                };
            }
        },
        close() {
            this.dialog = false;
        },
        async saveShipping() {
            let loader = this.$loading.show();
            const payload = {
                rider: this.rider,
                delivery_service_id: this.order.order_delivery_service.id,
            };

            const response = await this.$store.dispatch(
                "orderDeliveryService/shipping",
                payload
            );

            loader.hide();

            this.$swal({
                title: response.data.title,
                text: response.data.message,
                icon: response.data.icon,
                confirmButtonText: "รับทราบ",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.dialog = false;
                }
            });
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>

<style></style>
