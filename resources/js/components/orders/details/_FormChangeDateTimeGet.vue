<template>
    <div>
        <v-text-field
            label="วัน/เดือน/ปี"
            v-model="form.date"
            type="date"
            filled
            placeholder="กรุณาเลือกลูกค้า"
            @change="changeDateTime(form.date, form.time)"
        ></v-text-field>
        <v-select
            :items="timeGets"
            label="เวลา"
            filled
            v-model="form.time"
            @change="changeDateTime(form.date, form.time)"
        ></v-select>
    </div>
</template>

<script>
import OrderListsForchecked from "@/js/components/orders/OrderListsForchecked";
export default {
    props: ["form", "timeGets"],
    components: {
        OrderListsForchecked
    },
    data() {
        return {
            dateTime_get: "",
            headers: [
                { text: "Order.", value: "id" },
                { text: "ชื่อลูกค้า", value: "customer_name" },
                { text: "เบอร์โทรลูกค้า", value: "customer_phone" },
                { text: "วัน-เวลาที่รับ", value: "dateTime_get" },
                { text: "สถานะ", value: "order_status_id", align: "center" }
            ]
        };
    },
    methods: {
        async changeDateTime(date, time) {
            if (date && time) {
                this.dateTimeStatus = false;
                this.overlay = true;
                const dateTime_get = date + " " + time;
                const response = await this.$store.dispatch(
                    "order/checkDateTimeForGet",
                    dateTime_get
                );

                if (response.status == 200) {
                    const data = response.data.data;
                    this.dateTimeStatus = true;
                    this.dateTime_get = data.dateTime_get;
                    this.emitReplyOrder(data.orders);
                    this.$toast.success(response.data.message);
                    this.overlay = false;
                } else if (response.status == 400) {
                    this.dateTimeStatus = false;
                    this.dateTime_get = "";
                    this.emitReplyOrder();
                    this.$toast.error(response.data.message);
                    this.overlay = false;
                } else {
                    this.dateTimeStatus = false;
                    this.$toast.error(
                        "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง"
                    );
                    this.overlay = false;
                }
            }
        },
        emitReplyOrder(reply = []) {
            const emitData = {
                reply: reply,
                dateTimeStatus: this.dateTimeStatus,
                dateTime_get: this.dateTime_get
            };
            this.$emit("emitReplyOrder", emitData);
        }
    },
    mounted() {
        this.changeDateTime(this.form.date, this.form.time);
    }
};
</script>

<style></style>
