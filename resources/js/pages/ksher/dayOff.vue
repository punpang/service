<template>
    <div>
        <v-row class="mb-2">
            <v-col cols="12" md="6">
                <v-card class="mb-4" height="100%" elevation="1">
                    <v-card-title class="text-h6 white--text warning">
                        เลือกช่องทางชำระเงิน
                    </v-card-title>
                    <v-card-text>
                        <v-checkbox
                            v-for="ksher in ksherPay"
                            :key="ksher.id"
                            :label="ksher.text"
                            v-model="checkbox"
                            :value="ksher.id"
                            hide-details
                        ></v-checkbox>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <v-date-picker
                    v-model="dates"
                    range
                    :allowed-dates="allowedDates"
                    color="warning"
                    full-width
                    locale="th-TH"
                    elevation="1"
                ></v-date-picker>
            </v-col>
        </v-row>

        <v-btn x-large class="success" @click="clickSave()">
            <v-icon left>save</v-icon>
            บันทึกข้อมูล</v-btn
        >
        <v-btn x-large class="error" @click="clickReset()">
            <v-icon left>refresh</v-icon>
            ล้างข้อมูล</v-btn
        >
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            checkbox: [],
            dates: [],
        };
    },
    methods: {
        clickReset() {
            this.checkbox = [];
            this.dates = [];
        },
        async clickSave() {
            if (this.checkbox.length == 0) {
                this.$toast.error("โปรดเลือกช่องทางชำระเงิน");
                return;
            }
            if (this.dates.length != 2) {
                this.$toast.error("โปรดเลือกวันที่");
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                checkbox: this.checkbox,
                dates: this.dates,
            };
            const response = await this.$store.dispatch(
                "orderKsher/setDayOff",
                payload
            );

            if (response.status == 200) {
                this.$toast.success(response.data.message);
                this.clickReset();
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
            }

            loader.hide();
        },
        allowedDates(val) {
            const subDate = new Date();
            subDate.setDate(subDate.getDate() - 1);
            const date = subDate.toISOString().substr(0, 10);
            return val > date;
        },
        async getData() {
            let loader = this.$loading.show();
            const payload = {};
            const response = await this.$store.dispatch(
                "orderKsher/fetch",
                payload
            );
            loader.hide();
        },
    },
    mounted() {
        this.getData();
    },
    computed: {
        ...mapGetters({
            ksherPay: "orderKsher/ksherPay",
        }),
    },
};
</script>
