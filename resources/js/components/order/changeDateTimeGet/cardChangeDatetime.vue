<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                เปลี่ยนวัน-เวลานัดรับสินค้า
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pa-4">
                <p class="text-h6">วัน-เวลานัดรับสินค้า (เดิม)</p>
                <p class="ml-4">{{ order.date_get }} {{ order.time_get }}</p>
                <v-divider></v-divider>
                <p class="text-h6">วัน-เวลานัดรับสินค้า (ใหม่)</p>
                <v-alert
                    type="warning"
                    dense
                    v-if="
                        dateTimeGet.date_get == order.date_get_default &&
                        dateTimeGet.time_get == order.time_get
                    "
                >
                    โปรดเลือกวัน-เวลานัดรับใหม่
                </v-alert>
                <p class="ml-4" v-else>
                    {{ formatDate }} {{ dateTimeGet.time_get }}
                </p>
                <v-checkbox
                    label="แจ้งเตือนลูกค้า"
                    hide-details
                    v-model="alert_sms"
                ></v-checkbox>
            </v-card-text>
            <v-card-actions>
                <cardShowDateTime
                    @emitSaveNewDateTime="emitSaveNewDateTime"
                    :propDataTimeGet="dateTimeGet"
                    @click="clickStart()"
                ></cardShowDateTime>
                <v-spacer></v-spacer>
                <v-btn class="error" large @click="exit()">
                    <v-icon left>exit_to_app</v-icon>
                    ออก
                </v-btn>
                <v-btn
                    class="success"
                    large
                    @click="clickSave()"
                    :disabled="
                        dateTimeGet.date_get == order.date_get_default &&
                        dateTimeGet.time_get == order.time_get
                    "
                >
                    <v-icon left>save</v-icon>
                    บันทึก
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import cardShowDateTime from "@/js/components/order/changeDateTimeGet/cardShowDateTime";

export default {
    components: { cardShowDateTime },
    data() {
        return {
            dateTimeGet: {},
            alert_sms: true,
        };
    },
    methods: {
        emitSaveNewDateTime(v) {
            this.dateTimeGet = v;
        },
        async clickSave() {
            const payload = {
                order_id: this.order.id,
                date_time_get: this.dateTimeGet,
                alert_sms: this.alert_sms,
            };
            let loader = this.$loading.show();
            const result = await this.$store.dispatch(
                "orderIndex/changeDateTimeGet",
                payload
            );

            if (result.status == 200) {
                this.$toast.success(result.data.message);
                let loader = this.$loading.show();
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.order.id,
                });
                loader.hide();
                this.exit();
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางอย่าง");
            }
            loader.hide();
        },
        async getData() {
            const result = await this.$store.dispatch(
                "orderIndex/getOrderByID",
                {
                    orderID: this.$route.params.id,
                }
            );
            this.dateTimeGet = {
                date_get: this.order.date_get_default,
                time_get: this.order.time_get,
            };
        },
        exit() {
            this.$emit("emitExit");
        },
        padTo2Digits(num) {
            return num.toString().padStart(2, "0");
        },
    },
    mounted() {
        this.getData();
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            temp: "orderTemp/temp",
        }),
        formatDate() {
            const date = new Date(this.dateTimeGet.date_get);
            return [
                this.padTo2Digits(date.getDate()),
                this.padTo2Digits(date.getMonth() + 1),
                date.getFullYear() + 543,
            ].join("-");
        },
    },
};
</script>
