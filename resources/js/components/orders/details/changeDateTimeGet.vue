<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-list-item class="light-blue" v-on="on" @click="start">
                    <v-list-item-icon>
                        <v-icon>access_time</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="py-1"
                            >เปลี่ยนวัน-เวลารับสินค้า</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title>
                    เปลี่ยนวัน-เวลารับสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <FormChangeDateTimeGet
                        :form="form"
                        :timeGets="timeGets"
                        @emitReplyOrder="emitReplyOrder"
                    ></FormChangeDateTimeGet>
                    <v-alert
                        dense
                        text
                        :type="setColorDatetime(dateTime_get, dateTimeStatus)"
                        class="mb-1"
                    >
                        วัน-เวลารับสินค้า
                    </v-alert>
                    <v-alert
                        type="warning"
                        v-if="reply.order.counts"
                        dense
                        class="mb-1"
                        text
                    >
                        <OrderListsForchecked
                            :order="reply.order"
                            :headers="headers"
                        ></OrderListsForchecked>
                    </v-alert>

                    <formAlertSMS @emitAlert="emitAlert"></formAlertSMS>

                    <div class="mt-6">
                        <v-btn
                            @click="clickSubmit"
                            color="success"
                            :disabled="
                                dateTime_get == dataDateTimeGet ||
                                    !dateTimeStatus
                            "
                        >
                            <v-icon left>save</v-icon>
                            ยืนยัน
                        </v-btn>
                        <v-btn color="error" @click="dialog = false">
                            <v-icon left>exit_to_app</v-icon>
                            ออก
                        </v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import formAlertSMS from "@/js/components/others/form_alert_sms";
import OrderListsForchecked from "@/js/components/orders/OrderListsForchecked";
import FormChangeDateTimeGet from "@/js/components/orders/details/_FormChangeDateTimeGet";

export default {
    props: ["dataDateTimeGet"],
    components: {
        OrderListsForchecked,
        FormChangeDateTimeGet,
        formAlertSMS
    },
    data() {
        return {
            dialog: false,
            form: {
                date: "",
                time: ""
            },
            dateTime_get: "",
            dateTimeStatus: true,
            timeGets: [],
            reply: {
                order: {
                    counts: 0,
                    data: {}
                }
            },
            headers: [
                { text: "Order.", value: "id" },
                { text: "ชื่อลูกค้า", value: "customer_name" },
                { text: "เบอร์โทรลูกค้า", value: "customer_phone" },
                { text: "วัน-เวลาที่รับ", value: "dateTime_get" },
                { text: "สถานะ", value: "order_status_id", align: "center" }
            ],
            alertSMS: true
        };
    },
    methods: {
        async start() {
            let loader = this.$loading.show();
            const timeGets = await this.$store.dispatch("order/timeGets");
            this.timeGets = await timeGets;
            await this.CheckHasOrderDateTimeGet();
            this.alertSMS = true;
            loader.hide();
        },
        CheckHasOrderDateTimeGet() {
            if (this.dataDateTimeGet) {
                this.form.date = new Date(this.dataDateTimeGet)
                    .toJSON()
                    .slice(0, 10)
                    .replace(/-/g, "-");
                this.form.time = new Date(
                    this.dataDateTimeGet
                ).toLocaleString("th-TH", { timeStyle: "medium" });
                this.dateTime_get = this.dataDateTimeGet;
            } else {
                this.dateTime();
            }
        },
        dateTime() {
            this.form.date = new Date()
                .toJSON()
                .slice(0, 10)
                .replace(/-/g, "-");
        },
        emitReplyOrder(data) {
            this.reply.order = data.reply;
            this.dateTime_get = data.dateTime_get;
            this.dateTimeStatus = data.dateTimeStatus;
        },
        setColorDatetime(a, b) {
            if (a && b == true) {
                return "success";
            }
            return "warning";
        },
        async clickSubmit() {
            if (this.dateTimeStatus && this.dateTime_get) {
                let loader = this.$loading.show();
                const data = {
                    dateTime_get: this.dateTime_get,
                    order_id: this.$store.getters["order/getByID"].data.id,
                    alertSMS: this.alertSMS
                };
                const res = await this.$store.dispatch(
                    "order/changeDateTimeGet",
                    data
                );

                await this.$store.dispatch(
                    "order/getByID",
                    this.$store.getters["order/getByID"].data.id
                );

                if (res.status === 200) {
                    if (res.data.success) {
                        this.dialog = false;
                        this.$toast.success(res.data.message);
                    } else {
                        this.$toast.error(res.data.message);
                    }
                }
                loader.hide();
            } else {
                this.$toast.warning("กรุณากรอกวันและเวลาให้ครบถ้วน");
            }
        },
        emitAlert(data) {
            this.alertSMS = data.sms;
        }
    }
};
</script>

<style></style>
