<template>
    <div>
        <v-card-title class="text-h6 white--text warning">
            บริการจัดส่ง
            <v-spacer></v-spacer>
            <v-btn fab icon x-small>
                <v-icon class="white--text">close</v-icon>
            </v-btn>
        </v-card-title>
        <v-card-text class="pa-4">
            <formDelivery
                :propForm="propDeliveryService"
                @emitCustomerBuyer="emitCustomerBuyer"
            ></formDelivery>
            <!-- v-if="!order.order_delivery_service" -->
            <!-- <div v-else>
                <p>
                    ชื่อผู้รับ ::
                    {{ order.order_delivery_service.recipient_name }}
                </p>
                <p>
                    เบอร์โทรผู้รับ ::
                    {{ order.order_delivery_service.recipient_phone }}
                </p>
                <p>
                    ค่าบริการจัดส่ง ::
                    {{ order.order_delivery_service.delivery_fee }}
                </p>
                <p>หมายเหตุ :: {{ order.order_delivery_service.detail }}</p>
                <v-divider></v-divider>
                <a :href="order.order_delivery_service.link_google_maps"
                    >Link Google Maps</a
                >
            </div> -->
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn class="error" large @click="exit()">
                <v-icon left>exit_to_app</v-icon>
                ออก
            </v-btn>
            <v-btn class="success" large @click="clickSave()">
                <v-icon left>save</v-icon>
                บันทึก
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
import formDelivery from "@/js/components/order/delivery/formDelivery";
import { mapGetters } from "vuex";
export default {
    props: ["propDeliveryService"],
    components: { formDelivery },
    data() {
        return {
            default_form: {
                recipient_name: "",
                recipient_phone: "",
                delivery_fee: "0",
                link_google_maps: "",
                detail: "",
                service_fee: true,
                customerBuyer: false,
            },
        };
    },
    methods: {
        async clickSave() {
            if (
                this.propDeliveryService.recipient_name == "" ||
                this.propDeliveryService.recipient_phone == "" ||
                this.propDeliveryService.delivery_fee <= 0 ||
                this.propDeliveryService.link_google_maps == ""
            ) {
                this.$toast.warning("โปรดกรอกข้อมูลให้ครบถ้วน");
                return;
            }

            const payload = {
                order_id: this.order.id,
                form: this.propDeliveryService,
            };

            let loader = this.$loading.show();

            let result = {};
            if (!this.order.order_delivery_service) {
                // Create
                result = await this.$store.dispatch(
                    "orderDeliveryService/store",
                    payload
                );
            } else {
                // Update
                result = await this.$store.dispatch(
                    "orderDeliveryService/update",
                    payload
                );
            }

            if (result.status == 200) {
                this.$toast.success(result.data.message);
                let loader = this.$loading.show();
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.order.id,
                });
                this.exit();
                loader.hide();
            } else {
                this.$toast.error(result.data.message);
            }

            loader.hide();
        },
        exit() {
            // this.propDeliveryService = this.default_form;
            this.$emit("emitExit");
        },
        emitCustomerBuyer() {
            if (this.propDeliveryService.customerBuyer == true) {
                this.propDeliveryService.recipient_name =
                    this.order.customer.name;
                this.propDeliveryService.recipient_phone =
                    this.order.customer.tel;
            } else {
                this.propDeliveryService.recipient_name = "";
                this.propDeliveryService.recipient_phone = "";
            }
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
