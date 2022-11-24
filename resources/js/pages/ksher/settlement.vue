<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="6" class="pa-2">
                <v-menu
                    v-model="date1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="computedDateStartFormatted"
                            label="วันที่เริ่มต้น"
                            prepend-inner-icon="today"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            outlined
                            hide-details
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        locale="th-TH"
                        v-model="date_start"
                        @input="date1 = false"
                    ></v-date-picker>
                </v-menu>
            </v-col>
            <v-col md="4" cols="6" class="pa-2">
                <v-menu
                    v-model="date2"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="computedDateEndFormatted"
                            label="วันที่สิ้นสุด"
                            prepend-inner-icon="today"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            outlined
                            hide-details
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        locale="th-TH"
                        :allowed-dates="allowedDatesEnd"
                        v-model="date_end"
                        @input="date2 = false"
                    ></v-date-picker>
                </v-menu>
            </v-col>
            <v-col md="4" cols="12" class="pa-2">
                <v-btn block x-large @click="fetch" class="deep-orange" dark>
                    <v-icon left>search</v-icon>
                    ค้นหา
                </v-btn>
            </v-col>
        </v-row>

        <v-divider></v-divider>

        <v-data-table
            :headers="headers"
            :items="fetch_custom.kshers"
            :items-per-page="-1"
            hide-default-footer
            mobile-breakpoint="0"
        >
            <template v-slot:item.total_fee="{ item }">
                {{ item.total_fee | formatNumber }}
            </template>

            <template v-slot:item.result="{ item }">
                <v-btn x-small :class="classResult(item.result)">
                    {{ textResult(item.result) }}
                </v-btn>
            </template>
        </v-data-table>
        <v-divider></v-divider>

        <div class="d-flex flex-row justify-end">
            <v-card
            color="deep-orange"
            class="d-flex align-center"
            dark
            height="80"
            width="200"
        >
            <v-scroll-y-transition>
                <div class="text-h5 flex-grow-1 text-center">
                    {{ fetch_custom.sum_total_fee | formatNumber }}
                </div>
            </v-scroll-y-transition>
        </v-card>
        </div>


    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            date_start: "",
            date_end: "",
            date1: false,
            date2: false,
            headers: [
                { text: "#", value: "mch_order_no" },
                { text: "จำนวนเงิน", value: "total_fee" },
                { text: "สถานะ", value: "result" },
                { text: "วัน-เวลาทำรายการ", value: "updated_at_th" },
            ],
        };
    },
    methods: {
        // allowedDates(val) {
        //     const subDate = new Date();
        //     subDate.setDate(subDate.getDate() - 1);
        //     const date = subDate.toISOString().substr(0, 10);
        //     return val > date;
        // },
        classResult(v) {
            switch (v) {
                case "success":
                    return "success";
                    break;

                case "create":
                    return "info";
                    break;

                case "fail":
                    return "error";
                    break;

                default:
                    break;
            }
        },

        textResult(v) {
            switch (v) {
                case "success":
                    return "สำเร็จ";
                    break;

                case "create":
                    return "สร้างใหม่";
                    break;

                case "fail":
                    return "ล้มเหลว";
                    break;

                default:
                    break;
            }
        },
        allowedDatesEnd(val) {
            return val >= this.date_start;
        },
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split("-");
            let y = parseInt(year) + 543;
            return `${day}/${month}/${y}`;
        },
        async fetch() {
            if (this.date_start == "" || this.date_end == "") {
                return;
            }
            const payload = `date_start=${this.date_start}&date_end=${this.date_end}&result=success&sum_total_fee=true`;

            await this.$store.dispatch("orderKsher/fetch_custom", payload);
        },
    },
    computed: {
        computedDateStartFormatted() {
            const allow = this.allowedDatesEnd();
            return this.formatDate(this.date_start);
        },
        computedDateEndFormatted() {
            return this.formatDate(this.date_end);
        },

        ...mapGetters({
            fetch_custom: "orderKsher/fetch_custom",
        }),
    },
};
</script>

<style></style>
>
