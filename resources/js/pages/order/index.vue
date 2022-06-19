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
            <v-col cols="12" md="6">
                <v-text-field
                    outlined
                    v-model="search"
                    label="ค้นหา"
                    hide-details
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <searchSettings @submitSearch="submitSearch"></searchSettings>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :headers="headers"
            :items="orders"
            :search="search"
            hide-default-footer
            :items-per-page="99"
            mobile-breakpoint="0"
        >
            <template v-slot:item.date_get="{ item }">
                {{ item.date_get_th }} {{ item.time_get_format }}
            </template>

            <template v-slot:item.status="{ item }">
                <v-btn block :class="item.a_status.class">{{
                    item.a_status.status
                }}</v-btn>
            </template>

            <template v-slot:item.tags="{ item }">
                <v-btn rounded color="primary" dark x-small>
                    บริการจัดส่ง
                </v-btn>
                <br />
                <v-btn rounded color="warning" dark x-small>
                    ถ่ายรูปสินค้า
                </v-btn>
            </template>

            <template v-slot:item.manages="{ item }">
                <v-btn class="info" @click="clickToOrder(item.id)">
                    <v-icon left>search</v-icon>
                    ข้อมูล</v-btn
                >
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import searchSettings from "@/js/components/orders/search_settings";
export default {
    components: { searchSettings },
    data() {
        return {
            search: "",
            menu: false,
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            headers: [
                { text: "#", value: "id" },
                { text: "ชื่อ", value: "customer.name" },
                { text: "เบอร์โทรศัพท์", value: "customer.tel" },
                {
                    text: "วัน-เวลานัดรับ",
                    value: "date_get",
                    align: "center",
                },
                { text: "สถานะ", value: "status" },
                { text: "tags", value: "tags" },
                { text: "การจัดการ", value: "manages", align: "end" },
            ],
            search_settings: {},
        };
    },
    methods: {
        clickToOrder(id) {
            window.location.href = `/manages/order/${id}/showOrderByID`;
        },
        async fetch() {
            let loader = this.$loading.show();
            const payload = `date_get=${this.date}&sort_date_get=asc&makeHidden=sum_all&with=aStatus,customer&status=${this.search_settings.status}`;
            const result = await this.$store.dispatch(
                "orderIndex/fetch_orders",
                payload
            );
            loader.hide();
        },
        today() {
            const d = new Date();
            this.date = d.getDate();
        },
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split("-");
            let y = parseInt(year) + 543;
            return `${day}/${month}/${y}`;
        },
        async submitSearch(v) {
            this.search_settings = v;
            await this.fetch();
        },
    },
    // async mounted() {
    //     // await this.today();
    //     // await this.fetch();
    // },
    computed: {
        ...mapGetters({
            orders: "orderIndex/orders",
        }),
        computedDateFormatted() {
            return this.formatDate(this.date);
        },
    },
};
</script>

<style></style>
