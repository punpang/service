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
        <v-data-table
            :headers="headers"
            :items="details"
            hide-default-footer
            :search="search"
            :sort-by="['a_order.time_get']"
        >
            <template v-slot:item.a_price.name_goods="{ item }">
                <div class="py-3">
                    <p class="mb-0 font-weight-black text-subtitle-2">
                        {{ item.a_price.name_goods }}
                    </p>

                    <p
                        v-for="a in item.add_ons"
                        :key="a"
                        class="mb-1 text-body-2"
                    >
                        + {{ a.product_add_on.goods_add_on.name }}
                    </p>

                    <p
                        class="mb-1 text-caption info--text font-weight-black"
                        v-if="item.detail != '-'"
                    >
                        {{ item.detail }}
                    </p>

                    <v-btn
                        class="info"
                        x-small
                        rounded
                        v-if="item.product_prototypes.length > 0"
                    >
                        ต้นแบบสินค้า
                    </v-btn>

                    <v-btn
                        class="pink accent-2"
                        x-small
                        rounded
                        dark
                        v-if="item.add_ons.length > 0"
                    >
                        ตกแต่งเพิ่มเติม
                    </v-btn>

                    <!-- <v-btn class="indigo accent-3" x-small rounded dark>
                        ลูกบอล/ล้อม/ซ่อนเงิน
                    </v-btn> -->

                    <v-btn
                        class="cyan darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.a_order.order_delivery_service"
                    >
                        บริการจัดส่ง
                    </v-btn>

                    <v-btn
                        class="purple darken-3"
                        x-small
                        rounded
                        dark
                        v-if="item.is_take_a_photo"
                    >
                        ถ่ายรูปสินค้า
                    </v-btn>

                    <v-btn
                        class="lime darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.status_upload_images_from_customer"
                    >
                        รูปภาพลูกค้า
                    </v-btn>
                </div>
            </template>
            <!-- <template v-slot:item.tags="{ item }">
                <div class="py-3">
                    <v-btn
                        class="info"
                        x-small
                        rounded
                        v-if="item.product_prototypes.length > 0"
                    >
                        ต้นแบบสินค้า
                    </v-btn>

                    <v-btn
                        class="pink accent-2"
                        x-small
                        rounded
                        dark
                        v-if="item.add_ons.length > 0"
                    >
                        ตกแต่งเพิ่มเติม
                    </v-btn>

                    <v-btn class="indigo accent-3" x-small rounded dark>
                        ลูกบอล/ล้อม/ซ่อนเงิน
                    </v-btn>

                    <v-btn
                        class="cyan darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.a_order.order_delivery_service"
                    >
                        บริการจัดส่ง
                    </v-btn>

                    <v-btn
                        class="purple darken-3"
                        x-small
                        rounded
                        dark
                        v-if="item.is_take_a_photo"
                    >
                        ถ่ายรูปสินค้า
                    </v-btn>

                    <v-btn
                        class="lime darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.status_upload_images_from_customer"
                    >
                        รูปภาพลูกค้า
                    </v-btn>
                </div>
            </template> -->

            <template v-slot:item.manages="{ item }">
                <v-btn
                    class="info"
                    small
                    @click="clickToOrder(item.a_order.id)"
                >
                    <v-icon left>search</v-icon>
                    ดูข้อมูล
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            search: "",
            menu: false,
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            headers: [
                { text: "#", value: "a_order.id", width: "10%" },
                {
                    text: "เวลานัดรับ",
                    value: "a_order.time_get_format",
                    align: "center",
                    width: "10%",
                },
                {
                    text: "รายละเอียด",
                    value: "a_price.name_goods",
                },
                //{ text: "tags", value: "tags", width: "20%", align: "center" },
                {
                    text: "การจัดการ",
                    value: "manages",
                    align: "end",
                    width: "10%",
                },
            ],
            search_settings: {},
            timer: {},
        };
    },
    methods: {
        clickToOrder(id) {
            window.location.href = `/manages/order/${id}/showOrderByID`;
        },
        async fetch() {
            let loader = this.$loading.show();
            const payload = `date_get=${this.date}`;
            const result = await this.$store.dispatch(
                "orderIndex/fetch_orders_details",
                payload
            );
            loader.hide();
        },
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split("-");
            let y = parseInt(year) + 543;
            return `${day}/${month}/${y}`;
        },
    },
    async mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters({
            details: "orderIndex/orders_details",
        }),
        computedDateFormatted() {
            return this.formatDate(this.date);
        },
    },
};
</script>
