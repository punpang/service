<template>
    <div>
        <v-card outlined v-if="order.order_delivery_service">
            <v-card-title class="text-h6 white--text info">
                บริการจัดส่ง
                <v-spacer></v-spacer>
                <!-- <v-btn fab icon x-small class="white--text">
                    <v-icon>more_horiz</v-icon>
                </v-btn> -->
            </v-card-title>
            <v-card-text class="pa-3">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-card outlined height="100%">
                            <v-card-title class="text-h6 black-text pb-0">
                                ข้อมูลผู้รับ
                                <v-spacer></v-spacer>
                                <v-btn
                                    dark
                                    icon
                                    fab
                                    x-small
                                    class="info"
                                    :href="
                                        order.order_delivery_service
                                            .link_google_maps
                                    "
                                >
                                    <v-icon>location_on</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text class="px-4 pb-4">
                                <!-- <strong class="text-h6 black--text"
                                    >ข้อมูลผู้รับ</strong
                                > -->
                                <div class="mt-2">
                                    <strong>ชื่อผู้รับ ::</strong>
                                    <strong class="text-subtitle-1">{{
                                        order.order_delivery_service
                                            .recipient_name
                                    }}</strong>
                                </div>
                                <div>
                                    <strong>เบอร์โทรผู้รับ ::</strong>
                                    <strong class="text-subtitle-1">
                                        {{
                                            order.order_delivery_service
                                                .recipient_phone
                                        }}
                                    </strong>
                                </div>
                                <div>
                                    <strong>ค่าบริการจัดส่ง ::</strong>
                                    <strong class="text-subtitle-1"
                                        >{{
                                            order.order_delivery_service
                                                .delivery_fee | formatNumber
                                        }}
                                        บาท</strong
                                    >
                                </div>
                                <div>
                                    <strong>หมายเหตุ ::</strong>
                                    <strong class="text-subtitle-1">{{
                                        order.order_delivery_service.detail
                                    }}</strong>
                                </div>
                                <!-- <v-btn
                                    small
                                    class="info mt-2"
                                    :href="
                                        order.order_delivery_service
                                            .link_google_maps
                                    "
                                >
                                    <v-icon left>location_on</v-icon>
                                    Link Google Map</v-btn
                                > -->
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-card outlined height="100%">
                            <v-card-title class="text-h6 black-text pb-0">
                                ข้อมูลไรเดอร์
                                <v-spacer></v-spacer>
                                <v-btn
                                    dark
                                    icon
                                    fab
                                    x-small
                                    class="info"
                                    :href="
                                        order.order_delivery_service.rider_link
                                    "
                                >
                                    <v-icon>location_on</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text class="px-4 pb-4">
                                <!-- <strong class="text-h6 black--text"
                                    >ข้อมูลไรเดอร์</strong
                                > -->
                                <div class="mt-2">
                                    <strong>ชื่อไรเดอร์ ::</strong>
                                    <strong class="text-subtitle-1">{{
                                        order.order_delivery_service.rider_name
                                    }}</strong>
                                </div>
                                <div>
                                    <strong>เบอร์โทรไรเดอร์ ::</strong>
                                    <strong class="text-subtitle-1">{{
                                        order.order_delivery_service.rider_phone
                                    }}</strong>
                                </div>
                                <div>
                                    <strong>Delivery Platform ::</strong>
                                    <strong class="text-subtitle-1">{{
                                        order.order_delivery_service
                                            .delivery_platform
                                    }}</strong>
                                </div>
                                <div>
                                    <strong>หมายเหตุ ::</strong>
                                    <strong class="text-subtitle-1">{{
                                        order.order_delivery_service
                                            .rider_remark
                                    }}</strong>
                                </div>
                                <!-- <v-btn
                                    small
                                    class="info mt-2"
                                    :href="
                                        order.order_delivery_service
                                            .link_google_maps
                                    "
                                >
                                    <v-icon left>link</v-icon>
                                    Link Rider</v-btn
                                > -->
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions
                class="px-3 pb-3"
                v-if="order.status <= 8 && user.type == 1"
            >
                <btnDelivery
                    v-if="order.status != 8"
                    :propButton="'btn'"
                    class="mr-2"
                ></btnDelivery>
                <btnRider
                    v-if="
                        order.status == 8 &&
                        order.order_delivery_service.status != 'success'
                    "
                    :disabled="order.sum_all.sumBalance != 0"
                    class="mr-2"
                ></btnRider>
                <v-btn
                    class="success mr-2"
                    @click="saveSuccess()"
                    v-if="order.order_delivery_service.status == 'shipping'"
                >
                    <v-icon left>local_shipping</v-icon>
                    จัดส่งเรียบร้อย
                </v-btn>
                <v-btn
                    class="error"
                    @click="clickRemove()"
                    v-if="order.status < 8"
                >
                    <v-icon left>delete</v-icon>
                    ลบการจัดส่ง</v-btn
                >
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnDelivery from "@/js/components/order/delivery/btnDelivery";
import btnRider from "@/js/components/order/delivery/rider/btnRider";

var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    components: { btnDelivery, btnRider },
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
            // console.log(this.order.order_delivery_service.id);

            let loader = this.$loading.show();

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
                loader.hide();
            } else {
                this.$toast.error(result.data.message);
            }

            // loader.hide();
        },
        async saveSuccess() {
            this.$swal({
                icon: "warning",
                title: "คำเตือน",
                text: "จัดส่งสินค้าถึงลูกค้าแล้วใช่ไหม ?",
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่ , ถึงแล้ว",
                cancelButtonText: "ไม่ใช่ , ยังไม่ถึง",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.processinSuccess();
                }
            });
        },

        async processinSuccess() {
            let loader = this.$loading.show();

            const response = await this.$store.dispatch(
                "orderDeliveryService/success",
                {
                    delivery_service_id: this.order.order_delivery_service.id,
                }
            );

            loader.hide();

            this.$swal({
                title: response.data.title,
                text: response.data.message,
                icon: response.data.icon,
                confirmButtonText: "รับทราบ",
                allowOutsideClick: false,
            });
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            user: "main/User",
        }),
    },
};
</script>
