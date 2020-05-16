<template>
    <div>
        <v-card class="mb-3">
            <v-card-title>
                การจัดการ
                <v-spacer></v-spacer>
                <v-icon color="error" class=" d-none d-sm-flex" @click="emitDialogOff">close</v-icon>
            </v-card-title>
        </v-card>
        <v-list-item-group class="py-0">
            <formDetail
                :order="order"
                :action="action.create.detail"
            ></formDetail>

            <MainPayment
                v-show="order.order_status.id > 1"
                :count="count"
            ></MainPayment>

            <v-list-item @click="emitDialogOff" class="indigo darken-1">
                <v-list-item-icon>
                    <v-icon>directions_bus</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1">บริการจัดส่ง</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item class="error" v-show="order.order_status.id != 8">
                <v-list-item-icon>
                    <v-icon>cancel</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1">ยกเลิกรายการสั่งซื้อ</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="emitDialogOff" class="light-blue mt-4">
                <v-list-item-icon>
                    <v-icon>contacts</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1">เปลี่ยนผู้สั่งซื้อ</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="emitDialogOff" class="light-blue">
                <v-list-item-icon>
                    <v-icon >access_time</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title class="py-1">เปลี่ยนวัน-เวลารับสินค้า</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

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
import OrderDetailAdd from "@/js/components/orders/details/add";
import formDetail from "@/js/components/orders/details/_form_detail";
import MainPayment from "@/js/components/orders/payments/main";

export default {
    props: ["order", "count"],
    components: {
        formDetail,
        MainPayment
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
        },
        async testFacebook() {
            const response = await this.$store.dispatch("order/createOrder");
        },
        start() {
            this.setButtonByStatus();
        },
        setButtonByStatus() {
            switch (this.order.order_status.id) {
                case 4 || 5:
                    this.buttons = [
                        {
                            color: "warning",
                            text: "เตรียมสินค้าแล้ว",
                            status: 6
                        }
                    ];
                    break;
                case 6:
                    this.buttons = [
                        {
                            color: "warning",
                            text: "กำลังจัดส่งสินค้า",
                            status: 6
                        },
                        { color: "success", text: "รับสินค้าแล้ว", status: 8 }
                    ];
                    break;
                case 1:
                    this.button = {
                        color: "info",
                        text: "เตรียมสินค้าแล้ว",
                        status: 6
                    };
                    break;
            }
        }
    }
};
</script>

<style></style>
