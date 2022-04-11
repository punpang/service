<template>
    <div>
        <v-card>
            <v-card-title>
                <v-icon left>
                    {{ msgDateTimeGet.icon.main }}
                </v-icon>
                <h3>
                    {{ msgDateTimeGet.text.titleMain }}
                </h3>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="orders.length"
                    fab
                    x-small
                    color="error"
                    class="mb-2"
                    elevation="0"
                >
                    <strong>{{ orders.length }}</strong>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <!-- // -->
                {{ check }}
                <dateGet @emitDateGet="emitDateGet"></dateGet>
                <timeGet v-if="!dateWrong" @emitTimeGet="emitTimeGet"></timeGet>
                <v-btn
                    class="warning mb-4"
                    block
                    v-else
                    @click="dateWrong = false"
                    x-large
                >
                    <v-icon left>
                        {{ msgDateTimeGet.icon.clear }}
                    </v-icon>
                    {{ msgDateTimeGet.text.clearTimeGet }}
                </v-btn>
                <!-- // -->

                <!-- // -->
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import dateGet from "@/js/components/order/dataTimeGet/cardShow/dateGet";
import timeGet from "@/js/components/order/dataTimeGet/cardShow/timeGet";
export default {
    props: ["propCountSetTemp"],
    components: {
        dateGet,
        timeGet,
    },
    data() {
        return {
            // dateGet: "",
            // timeGet: "",
            dateWrong: false,
            orders: {},

        };
    },
    methods: {
        emitDateGet() {
            if (this.dateWrong === true) {
                this.temp.temp.dateTimeGet.timeGet = "";
            }
            // this.checkDateGet();
            // this.checkDateTimeGet();
        },
        emitTimeGet() {
            // this.temp.temp.dateTimeGet.timeGet = v;
            // this.checkDateTimeGet();
        },
        async checkDateTimeGet() {
            if (
                !this.temp.temp.dateTimeGet.dateGet ||
                !this.temp.temp.dateTimeGet.timeGet
            )
                return;
            // ไม่มีวันที่ หรือ เวลา หยุดทำงาน
            let loader = this.$loading.show();
            const data = this.temp.temp.dateTimeGet;
            const result = await this.$store.dispatch(
                "orderDateTimeGet/checkDateTimeGet",
                data
            );
            this.orders = result.data;
            loader.hide();
        },
        checkDateGet() {
            const datetimeNow = new Date();
            const dateTimeGet = new Date(
                this.temp.temp.dateTimeGet.dateGet +
                    " " +
                    this.temp.temp.dateTimeGet.timeGet +
                    ":00"
            );
            const diffDateTime = dateTimeGet.valueOf() - datetimeNow.valueOf();
            if (isNaN(diffDateTime)) {
                return;
            } else if (diffDateTime < 1800000) {
                const date = new Date().toISOString().substr(0, 10);
                this.temp.temp.dateTimeGet.dateGet = date;
                this.temp.temp.dateTimeGet.timeGet = "";
                this.$swal({
                    title: "โปรดเลือกวัน-เวลานัดรับใหม่",
                    icon: "warning",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                    timer: 3000,
                    timerProgressBar: true,
                });
                return;
            }
        },
    },
    computed: {
        ...mapGetters({
            msgDateTimeGet: "orderDateTimeGet/msg",
            temp: "orderTemp/temp",
        }),
        check() {
            this.checkDateGet();
            this.checkDateTimeGet();
        },
    },
};
</script>
