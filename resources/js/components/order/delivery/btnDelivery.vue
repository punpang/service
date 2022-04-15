<
<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="500"
            scrollable
            persistent
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on" @click="clickStart()">
                    <v-list-item-title class="py-1">
                        บริการจัดส่ง
                    </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <cardDelivery
                    @emitExit="emitExit"
                    :propDeliveryService="form"
                ></cardDelivery>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardDelivery from "@/js/components/order/delivery/cardDelivery";
import { mapGetters } from "vuex";
export default {
    components: { cardDelivery },
    data() {
        return {
            dialog: false,
            form: {
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
        emitExit() {
            this.dialog = false;
        },
        async getData() {
            let loader = this.$loading.show();
            this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });

            if (this.order.order_delivery_service) {
                this.form = this.order.order_delivery_service;
                if (
                    this.form.recipient_phone ==
                    this.order.order_delivery_service.recipient_phone
                ) {
                    this.form.customerBuyer = true;
                }
            }

            loader.hide();
        },
        clickStart() {
            this.getData();
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
