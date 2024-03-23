<template>
    <div>
        <v-row class="mt-1">
            <v-col cols="12" md="3">
                <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    :return-value.sync="date"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="computedDateFormatted"
                            label="วันที่นัดรับ"
                            hide-details
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            outlined
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="date"
                        no-title
                        scrollable
                        locale="th-TH"
                    >
                        <v-spacer></v-spacer>

                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(date), fetch()"
                        >
                            เลือก
                        </v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" md="9">
                <v-text-field
                    label="ค้นหา"
                    v-model="search"
                    outlined
                    hide-details
                ></v-text-field>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-tabs v-model="tab">
            <v-tab>
                <v-badge
                    color="deep-orange"
                    :content="details.length > 0 ? details.length : '0'"
                >
                    Order
                </v-badge>
            </v-tab>

            <v-tab
                ><v-badge
                    color="deep-orange"
                    :content="pos.length > 0 ? pos.length : '0'"
                >
                    pos
                </v-badge></v-tab
            >
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item>
                <orderDetailLists :propSearch="search"></orderDetailLists>
            </v-tab-item>
            <v-tab-item class="py-2">
                <orderPosLists></orderPosLists>
            </v-tab-item>
        </v-tabs-items>

    </div>
</template>

<script>
import { mapGetters } from "vuex";
// import imageThumbnailPathSizeFree from "@/js/components/google/drive/imageThumbnailPathSizeFree";

import orderDetailLists from "@/js/components/details/order_detail_lists";
import orderPosLists from "@/js/components/details/order_pos_lists";

export default {
    components: {
        // imageThumbnailPathSizeFree,
        orderDetailLists,
        orderPosLists,
    },
    data() {
        return {
            tab: null,
            search: "",
            menu: false,
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            // headers: [
            //     { text: "#", value: "a_order.id", width: "10%" },
            //     {
            //         text: "เวลานัดรับ",
            //         value: "a_order.time_get_format",
            //         align: "center",
            //         width: "10%",
            //     },
            //     {
            //         text: "รูปภาพ",
            //         value: "image_goods",
            //         width: "5%",
            //     },
            //     {
            //         text: "รายละเอียด",
            //         value: "a_price.name_goods",
            //     },
            //     //{ text: "tags", value: "tags", width: "20%", align: "center" },
            //     {
            //         text: "การจัดการ",
            //         value: "manages",
            //         align: "end",
            //         width: "10%",
            //     },
            // ],
            // search_settings: {},
            // timer: {},.
            timer: {},
        };
    },
    methods: {
        // src_name(v) {
        //     console.log(v.src_name);
        // },
        // clickToOrder(id) {
        //     window.location.href = `/manages/order/${id}/showOrderByID`;
        // },
        async fetch() {
            // clearTimeout(this.timer.running);
            // // console.log(this.$route.fullPath)
            // if (this.$route.fullPath == "/manages/order/details") {
            //     this.count_time();
            // } else {
            //     return;
            // }

            let loader = this.$loading.show();
            const payload = `date_get=${this.date}`;
            const result = await this.$store.dispatch(
                "orderIndex/fetch_orders_details",
                payload
            );

            const result_pos = await this.$store.dispatch(
                "orderIndex/fetch_orders_details_pos",
                payload
            );

            if (this.pos.length >= 1) {
                this.$swal({
                    title: "มีรายการสั่งซื้อใน POS",
                    icon: "warning",
                    confirmButtonText: "รับทราบ",
                });
            }

            loader.hide();
        },
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split("-");
            let y = parseInt(year) + 543;
            return `${day}/${month}/${y}`;
        },
        count_time() {
            this.timer.running = setTimeout(this.fetch, 20000);
        },
    },
    async mounted() {
        this.fetch();
        // this.count_time();
    },
    computed: {
        ...mapGetters({
            details: "orderIndex/orders_details",
            pos: "orderIndex/orders_details_pos",
        }),
        computedDateFormatted() {
            return this.formatDate(this.date);
        },
    },
};
</script>
