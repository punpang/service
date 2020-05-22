<template>
    <div>
        <v-card class="mb-3">
            <v-card-title>
                การจัดการ
                <v-spacer></v-spacer>
                <v-icon
                    color="error"
                    class=" d-none d-sm-flex"
                    @click="emitDialogOff"
                    >close</v-icon
                >
            </v-card-title>
        </v-card>
        <v-list-item-group class="py-0">
            <goodsDone
                v-if="count.product.use && order.order_status_id == 4"
                class="mb-4"
            ></goodsDone>

            <productReceived
                v-if="order.order_status_id == 6"
                :sum="sum"
            ></productReceived>

            <v-list-item
                class="deep-orange darken-1 mb-4"
                v-if="order.order_status_id == 6"
            >
                <v-list-item-icon>
                    <v-icon>error_outline</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1"
                        >เตรียมสินค้าผิด
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <formDetail
                v-if="order.order_status_id <= 5"
                class="mt-4"
                :order="order"
                :action="action.create.detail"
            ></formDetail>

            <MainPayment
                v-if="order.order_status.id >= 1 && order.order_status.id <= 6 && sum.total > 0"
                :count="count"
            ></MainPayment>

            <v-list-item
                @click="emitDialogOff"
                class="indigo darken-1"
                v-if="order.order_status.id >= 2 && order.order_status.id <= 5"
            >
                <v-list-item-icon>
                    <v-icon>local_shipping</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1"
                        >บริการจัดส่ง</v-list-item-title
                    >
                </v-list-item-content>
            </v-list-item>

            <v-list-item class="error mb-4" v-if="order.order_status.id <= 7">
                <v-list-item-icon>
                    <v-icon>cancel</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1"
                        >ยกเลิกรายการสั่งซื้อ</v-list-item-title
                    >
                </v-list-item-content>
            </v-list-item>

            <v-list-item
                @click="emitDialogOff"
                class="light-blue"
                v-if="order.order_status_id <= 5"
            >
                <v-list-item-icon>
                    <v-icon>contacts</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1"
                        >เปลี่ยนผู้สั่งซื้อ</v-list-item-title
                    >
                </v-list-item-content>
            </v-list-item>

            <changeDateTimeGet
                :dataDateTimeGet="order.dateTime_get"
                v-if="order.order_status_id < 6"
            ></changeDateTimeGet>

            <v-list-item @click="emitDialogOff" class="red accent-4 mt-4" dark>
                <v-list-item-icon>
                    <v-icon>exit_to_app</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1">ออก</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list-item-group>
    </div>
</template>

<script>
import formDetail from "@/js/components/orders/details/_form_detail";
import MainPayment from "@/js/components/orders/payments/main";
import changeDateTimeGet from "@/js/components/orders/details/changeDateTimeGet";
import goodsDone from "@/js/components/orders/details/goodsDone";
import productReceived from "@/js/components/orders/details/productReceived";

export default {
    props: ["order", "count", "sum"],
    components: {
        formDetail,
        MainPayment,
        changeDateTimeGet,
        goodsDone,
        productReceived
    },
    data() {
        return {
            dialog: false,
            buttons: [],
            action: {
                create: {
                    detail: {
                        method: "create",
                        title: "เพิ่มสินค้าใหม่",
                        icon: "add_shopping_cart"
                    }
                }
            }
        };
    },
    methods: {
        emitDialogOff() {
            this.$emit("emitDialogOff");
        }
    }
};
</script>

<style></style>
