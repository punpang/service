<template>
    <div>
        <v-item-group :mandatory="true">
            <v-row>
                <v-col
                    cols="6"
                    md="3"
                    v-for="{
                        text,
                        count,
                        textSmall,
                        textBig,
                        colorBlock,
                        colorText
                    } in dataSelect"
                    :key="text"
                >
                    <div @click="clickOrderSelect(text)">
                        <v-item v-slot:default="{ active, toggle }">
                            <v-card
                                shaped
                                :color="active ? colorBlock : ''"
                                @click="toggle"
                            >
                                <v-card-text>
                                    <p
                                        class="display-2 font-weight-black mb-2"
                                        :class="active ? colorText : ''"
                                    >
                                        {{ count }}
                                    </p>
                                    <p
                                        class="subtitle-1 ma-0 d-none d-sm-flex"
                                        :class="active ? colorText : ''"
                                    >
                                        {{ textBig }}
                                    </p>
                                    <p
                                        class="subtitle-1 ma-0 d-flex d-sm-none"
                                        :class="active ? colorText : ''"
                                    >
                                        {{ textSmall }}
                                    </p>
                                </v-card-text>
                            </v-card>
                        </v-item>
                    </div>
                </v-col>
            </v-row>
        </v-item-group>
        <v-container>
            <v-row>
                <OrderCreate
                    @OnDataTable="OnDataTable"
                    class="mr-2"
                    :headers="headers"
                ></OrderCreate>
                <v-btn class="info" fab x-small @click="reload">
                    <v-icon>refresh</v-icon>
                </v-btn>
            </v-row>
        </v-container>
        <OrderTable
            :dataTable="dataTable"
            :headers="headers"
            @emitDialogTableFalse="emitDialogTableFalse"
        ></OrderTable>
        <snackbarRight :snackbar="snackbar"></snackbarRight>
        <overlay :overlay="overlay"></overlay>
    </div>
</template>

<script>
import OrderTable from "@/js/components/orders/OrderTable";
import OrderCreate from "@/js/components/orders/OrderCreate";
import snackbarRight from "@/js/layouts/snackbarRight";
import overlay from "@/js/layouts/overlay";

export default {
    components: {
        OrderTable,
        OrderCreate,
        snackbarRight,
        overlay
    },
    data() {
        return {
            dataTable: [],
            snackbar: {
                status: false
            },
            selected_table:"today",
            overlay: false,
            counts: {
                today: 0,
                notify: 0,
                tomorrow: 0,
                created: 0
            },
            orders: {
                today: {},
                notify: {},
                created: {}
            },
            headers: [
                { text: "Order.", value: "id" },
                { text: "ชื่อลูกค้า", value: "customer_name" },
                { text: "เบอร์โทรลูกค้า", value: "customer_phone" },
                { text: "วัน-เวลาที่รับ", value: "dateTime_get" },
                { text: "สถานะ", value: "order_status_id", align: "center" },
                { text: "การจัดการ", value: "action", align: "end" }
            ],
            dataSelect: []
        };
    },
    methods: {
        emitDialogTableFalse() {
            this.reload();
        },
        clickOrderSelect(value) {
            if (value == "today") {
                this.dataTable = this.orders.today;
            } else if (value == "notify") {
                this.dataTable = this.orders.notify;
            } else if (value == "created") {
                this.dataTable = this.orders.created;
            } else if (value == "tomorrow") {
                this.dataTable = this.orders.tomorrow;
            } else if (value == "") {
            } else {
                this.snackbar = {
                    status: true,
                    text: "กรุณาลองใหม่อีกครั้งค่ะ",
                    color: "error"
                };
            }
            this.selected_table = value;
        },
        OnDataTable() {
            this.reload();
        },
        async reload() {
            this.overlay = true;
            this.dataTable = [];
            await this.$store.dispatch("order/all");
            const dataTable = await this.$store.getters["order/all"];
            this.orders = {
                today: dataTable.todayOrder,
                notify: dataTable.notifyOrder,
                created: dataTable.createdOrder,
                tomorrow: dataTable.tomorrowOrder
            };
            this.dataTable = this.orders.today;
            this.dataSelect = dataTable.menus;
            this.clickOrderSelect(this.selected_table);
            this.overlay = false;
        }
    },
    async mounted() {
        this.reload();
    }
};
</script>

<style></style>
