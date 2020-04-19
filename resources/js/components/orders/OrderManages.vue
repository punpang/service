<template>
    <div>
        <v-dialog v-model="dialog" persistent width="300">
            <template v-slot:activator="{ on }">
                <v-btn class="warning" fab x-small v-on="on" @click="start"
                    ><v-icon>edit</v-icon></v-btn
                >
            </template>
            <v-card>
                <v-card-title>
                    การจัดการ
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <OrderDetailAdd :order="order"></OrderDetailAdd>
                    <v-btn
                        block
                        color="warning"
                        class="mb-2"
                        @click="testFacebook"
                        >ชำระเงิน</v-btn
                    >
                    <v-btn block color="info">ส่งลิงก์สำหรับอัปโหลดรูป</v-btn>
                    <hr class="my-2" />
                    <v-btn block color="info" class="mb-2"
                        >เปลี่ยนแปลงผู้ส่งซื้อ</v-btn
                    >
                    <v-btn block color="info"
                        >เปลี่ยนแปลงวัน-เวลาที่รับสินค้า</v-btn
                    >
                    <hr class="my-2" />
                    <div
                        v-for="{ index, color, status, text } in buttons"
                        :key="index"
                    >
                        <v-btn
                            block
                            :color="color"
                            @click="clickUpdateStatus(status)"
                            class="mb-2"
                            >{{ text }}</v-btn
                        >
                    </div>
                    <v-btn
                        v-if="this.order.order_status.id != 8"
                        block
                        color="error"
                        >ยกเลิกรายการสั่งซื้อ</v-btn
                    >
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import OrderDetailAdd from "@/js/components/orders/details/add";

export default {
    props: ["order"],
    components: {
        OrderDetailAdd
    },
    data() {
        return {
            dialog: false,
            buttons: []
        };
    },
    methods: {
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
