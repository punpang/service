<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="600"
            persistent
            background-color="grey lighten-2"
        >
            <template v-slot:activator="{ on }">
                <v-btn color="orange" dark v-on="on" @click="start">
                    <v-icon left="">add</v-icon>
                    รายการใหม่
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">สร้างรายการสั่งซื้อใหม่</span>
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-card outlined>
                                <v-card-title class="pb-0">
                                    <span>ข้อมูลลูกค้า</span>
                                    <v-spacer></v-spacer>
                                    <selectCustomer
                                        @onCustomer="onCustomer"
                                    ></selectCustomer>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text class="py-0">
                                    <v-text-field
                                        label="ชื่อ"
                                        v-model="form.customer.name"
                                        readonly
                                        filled
                                        placeholder="กรุณาเลือกลูกค้า"
                                    ></v-text-field>
                                    <v-text-field
                                        label="เบอร์โทร"
                                        v-model="form.customer.phone"
                                        readonly
                                        filled
                                        placeholder="กรุณาเลือกลูกค้า"
                                    ></v-text-field>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-card outlined>
                                <v-card-title class="pb-0">
                                    <span>วัน-เวลารับสินค้า</span>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="orange"
                                        x-small
                                        fab
                                        depressed
                                        dark
                                        ><v-icon>event_note</v-icon></v-btn
                                    >
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text class="py-0">
                                    <v-text-field
                                        label="วัน/เดือน/ปี"
                                        v-model="form.date"
                                        type="date"
                                        filled
                                        placeholder="กรุณาเลือกลูกค้า"
                                        @change="
                                            changeDateTime(form.date, form.time)
                                        "
                                    ></v-text-field>
                                    <v-select
                                        :items="timeGets"
                                        label="เวลา"
                                        filled
                                        v-model="form.time"
                                        @change="
                                            changeDateTime(form.date, form.time)
                                        "
                                    ></v-select>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="12" class="pt-0">
                            <v-card>
                                <v-card-title class="pb-0">
                                    <span>ช่องทางการสั่งซื้อ</span>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-chip-group
                                    v-model="formData.channel_of_purchase_id"
                                    column
                                    class="px-4 pb-3"
                                    active-class="success text--accent-4"
                                >
                                    <v-chip
                                        filter
                                        v-for="{
                                            id,
                                            name
                                        } in channel_of_purchases"
                                        :key="id"
                                        :value="id"
                                    >
                                        {{ name }}</v-chip
                                    >
                                </v-chip-group>
                            </v-card>
                        </v-col>
                    </v-row>

                    <v-alert
                        dense
                        text
                        :type="setColorCustomer(formData.customer_id)"
                        class="mb-1"
                    >
                        ข้อมูลลูกค้า
                    </v-alert>
                    <v-alert
                        dense
                        text
                        :type="
                            setColorDatetime(
                                formData.dateTime_get,
                                dateTimeStatus
                            )
                        "
                        class="mb-1"
                    >
                        วัน-เวลารับสินค้า
                    </v-alert>
                    <v-alert
                        dense
                        text
                        :type="
                            setColorChannelOfPurchase(
                                formData.channel_of_purchase_id
                            )
                        "
                        class="mb-1"
                    >
                        ช่องทางการสั่งซื้อ
                    </v-alert>
                    <v-alert
                        v-show="reply.order.counts > 0"
                        dense
                        text
                        type="warning"
                        class="mb-1"
                    >
                        <OrderListsForchecked
                            :order="reply.order"
                            :headers="headers"
                        ></OrderListsForchecked>
                    </v-alert>
                    <v-form ref="form" lazy-validation>
                        <div v-show="1 == 0">
                            <v-text-field
                                label="customer_id"
                                v-model="formData.customer_id"
                                readonly
                                :rules="Rules.customer_id"
                            ></v-text-field>
                            <v-text-field
                                label="channel_of_purchase_id"
                                v-model="formData.channel_of_purchase_id"
                                readonly
                                :rules="Rules.channel_of_purchase_id"
                            ></v-text-field>
                            <v-text-field
                                label="dateTime_get"
                                v-model="formData.dateTime_get"
                                readonly
                                :rules="Rules.dateTime_get"
                            ></v-text-field>
                        </div>
                    </v-form>
                </v-card-text>
                <v-divider class="ma-0"></v-divider>
                <v-card-actions>
                    <v-container class="text-right">
                        <v-btn color="success" @click="save">
                            <v-icon left>save</v-icon>
                            สร้างรายการสั่งซื้อใหม่</v-btn
                        >

                        <v-btn color="error" @click="reset">
                            <v-icon left>clear</v-icon>
                            ล้างข้อมูล</v-btn
                        >
                    </v-container>
                </v-card-actions>
            </v-card>
            <v-overlay :value="overlay">
                <v-progress-circular
                    indeterminate
                    :size="this.$store.getters['main/sizeOverlay']"
                ></v-progress-circular>
            </v-overlay>
        </v-dialog>
        <snackbarRight :snackbar="snackbar"></snackbarRight>
    </div>
</template>

<script>
import selectCustomer from "@/js/components/customers/selectCustomer";
import snackbarRight from "@/js/layouts/snackbarRight";
import OrderListsForchecked from "@/js/components/orders/OrderListsForchecked";

export default {
    props: ["headers"],
    components: {
        selectCustomer,
        snackbarRight,
        OrderListsForchecked
    },
    data() {
        return {
            overlay: false,
            dialog: false,
            reply: {
                order: {
                    counts: 0,
                    data: {}
                }
            },
            form: {
                customer: {
                    id: "",
                    name: "",
                    phone: ""
                },
                date: "",
                time: ""
            },
            formDefalut: {
                customer: {
                    id: "",
                    name: "",
                    phone: ""
                },
                date: "",
                time: ""
            },
            formData: {
                customer_id: "",
                dateTime_get: "",
                channel_of_purchase_id: ""
            },
            channel_of_purchases: [],
            timeGets: [],
            Rules: {
                customer_id: [v => !!v],
                dateTime_get: [v => !!v],
                channel_of_purchase_id: [v => !!v]
            },
            snackbar: {
                status: false
            },
            dateTimeStatus: false
        };
    },
    methods: {
        setColorDatetime(a, b) {
            if (a && b == true) {
                return "success";
            }
            return "warning";
        },
        setColorCustomer(value) {
            if (value) {
                return "success";
            }
            return "warning";
        },
        setColorChannelOfPurchase(value) {
            if (value) {
                return "success";
            }
            return "warning";
        },
        onCustomer(value) {
            this.form.customer = {
                id: value.id,
                name: value.name,
                phone: value.phone
            };

            this.formData.customer_id = value.id;
        },
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
                    this.formData.dateTime_get = data.dateTime_get;
                    this.reply.order = data.orders;
                    this.snackbar = {
                        status: true,
                        text: response.data.message,
                        color: "success"
                    };
                    this.overlay = false;
                } else if (response.status == 400) {
                    this.snackbar = {
                        status: true,
                        text: response.data.message,
                        color: "error"
                    };
                    this.overlay = false;
                } else {
                    this.snackbar = {
                        status: true,
                        text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง",
                        color: "error"
                    };
                    this.overlay = false;
                }
            }
        },
        async start() {
            this.overlay = true;
            this.reset();
            const channel_of_purchases = await this.$store.dispatch(
                "channelOfPurchase/UseOnly"
            );
            this.channel_of_purchases = channel_of_purchases.data;

            const timeGets = await this.$store.dispatch("order/timeGets");
            this.timeGets = timeGets;
            this.overlay = false;
        },
        dateTime() {
            this.form.date = new Date()
                .toJSON()
                .slice(0, 10)
                .replace(/-/g, "-");
        },
        reset() {
            this.form = {
                customer: {
                    id: "",
                    name: "",
                    phone: ""
                },
                date: "",
                time: ""
            };

            this.dateTime();

            this.formData = {
                customer_id: "",
                dateTime_get: "",
                channel_of_purchase_id: ""
            };
        },
        async save() {
            if (this.$refs.form.validate()) {
                this.overlay = true;
                const response = await this.$store.dispatch(
                    "order/createOrder",
                    this.formData
                );
                if (response.status == 200) {
                    await this.$emit("OnDataTable");
                    this.snackbar = {
                        status: true,
                        text: "สร้างรายการใหม่สำเร็จ",
                        color: "success"
                    };
                    this.dialog = false;
                    this.overlay = false;
                }
            } else {
                this.snackbar = {
                    status: true,
                    text: "กรุณาตรวจสอบ กรอกข้อมูลไม่ครบถ้วน",
                    color: "warning"
                };
            }
        }
    }
};
</script>

<style></style>
