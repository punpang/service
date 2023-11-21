<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                {{ propCoupon ? "แก้ไขคูปอง" : "สร้างคูปอง" }}
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pt-5">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field
                            outlined
                            label="ชื่อคูปอง"
                            hide-details
                            class="mb-3"
                            v-model="coupon.title"
                        ></v-text-field>

                        <v-text-field
                            pattern="\d*"
                            type="number"
                            outlined
                            label="ยอดขั้นต่ำ"
                            hide-details
                            class="mb-3"
                            suffix="บาท"
                            v-model="coupon.minimum"
                        ></v-text-field>

                        <v-text-field
                            pattern="\d*"
                            type="number"
                            outlined
                            label="ส่วนลดสูงสุด"
                            hide-details
                            class="mb-3"
                            suffix="บาท"
                            v-model="coupon.maximum"
                        ></v-text-field>

                        <v-text-field
                            pattern="\d*"
                            type="number"
                            outlined
                            label="ส่วนลดเปอร์เซนต์"
                            hide-details
                            class="mb-3"
                            suffix="เปอร์เซนต์"
                            v-model="coupon.percent"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-menu
                            v-model="date_start"
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
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    hide-details
                                    outlined
                                    class="mb-3"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="coupon.date_start"
                                @input="date_start = false"
                                locale="th-TH"
                            ></v-date-picker>
                        </v-menu>

                        <v-menu
                            v-model="date_end"
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
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    hide-details
                                    outlined
                                    class="mb-3"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="coupon.date_end"
                                @input="date_end = false"
                                locale="th-TH"
                            ></v-date-picker>
                        </v-menu>

                        <v-text-field
                            pattern="\d*"
                            type="number"
                            outlined
                            label="จำนวนครั้งสูงสุด"
                            hide-details
                            class="mb-3"
                            v-model="coupon.limit_times"
                        ></v-text-field>

                        <v-textarea
                            outlined
                            label="หมายเหตุ"
                            hide-details
                            class="mb-3"
                            v-model="coupon.remark"
                        ></v-textarea>
                    </v-col>
                </v-row>

                <!-- <v-btn text block large class="info--text" v-if="propGoods">
                    <v-icon left>link</v-icon> ผูกวัตถุดิบ
                </v-btn> -->

                <!-- <v-btn text block large class="error--text" v-if="propGoods">
                    <v-icon left>delete</v-icon> ลบรายการนี้
                </v-btn> -->
            </v-card-text>
            <v-card-actions>
                <v-btn class="error" @click="exit()">
                    <v-icon left>exit_to_app</v-icon> ออก
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn class="orange" dark @click="clickSave()">
                    <v-icon left>save</v-icon>
                    บันทึก
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propCoupon"],
    data() {
        return {
            dialog: false,
            date_start: false,
            date_end: false,
            coupon: {
                title: "",
                minimum: 1,
                maximum: 1,
                percent: 100,
                date_start: new Date(
                    Date.now() - new Date().getTimezoneOffset() * 60000
                )
                    .toISOString()
                    .substr(0, 10),
                date_end: new Date(
                    Date.now() - new Date().getTimezoneOffset() * 60000
                )
                    .toISOString()
                    .substr(0, 10),
                limit_times: 1,
                customer_id: "",
                remark: "",
            },
        };
    },
    methods: {
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split("-");
            let y = parseInt(year) + 543;
            return `${day}/${month}/${y}`;
        },

        reset() {
            this.coupon = {
                title: "",
                minimum: 1,
                maximum: 1,
                percent: 100,
                date_start: new Date(
                    Date.now() - new Date().getTimezoneOffset() * 60000
                )
                    .toISOString()
                    .substr(0, 10),
                date_end: new Date(
                    Date.now() - new Date().getTimezoneOffset() * 60000
                )
                    .toISOString()
                    .substr(0, 10),
                limit_times: 1,
                customer_id: "",
                remark: "",
            };
        },
        swal_error(title, text) {
            this.$swal({
                toast: true,
                title: title,
                text: text,
                icon: "warning",
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                position: "bottom",
            });
        },
        async clickSave() {
            if (this.coupon.title == "") {
                this.swal_error("ชื่อคูปอง", "ห้ามว่าง");
                return;
            }

            if (this.coupon.minimum == "" || this.coupon.minimum < 1) {
                this.swal_error("ยอดขั้นต่ำ", "ห้ามว่าง หรือ มีค่าตั้งแต่ 1");
                return;
            }

            if (this.coupon.maximum == "" || this.coupon.maximum < 1) {
                this.swal_error("ส่วนลดสูงสุด", "ห้ามว่าง หรือ มีค่าตั้งแต่ 1");
                return;
            }

            if (
                this.coupon.percent == "" ||
                this.coupon.percent < 1 ||
                this.coupon.percent > 100
            ) {
                this.swal_error(
                    "ส่วนลดเปอร์เซนต์",
                    "ห้ามว่าง หรือ มีค่าตั้งแต่ 1 แต่ไม่มากกว่า 100"
                );
                return;
            }

            if (this.coupon.date_start == "") {
                this.swal_error("วันที่เริ่มต้น", "ห้ามว่าง");
                return;
            }

            if (this.coupon.date_end == "") {
                this.swal_error("วันที่สิ้นสุด", "ห้ามว่าง");
                return;
            }

            if (this.coupon.date_start > this.coupon.date_end) {
                this.swal_error(
                    "วันที่เริ่มต้น < วันที่สิ้นสุด",
                    "วันที่เริ่มต้น ต้องน้อยกว่า วันที่สิ้นสุด"
                );
                return;
            }

            if (this.coupon.limit_times == "" || this.coupon.limit_times < 1) {
                this.swal_error(
                    "จำนวนครั้งสูงสุด",
                    "ห้ามว่าง หรือ มีค่าตั้งแต่ 1"
                );
                return;
            }

            // let loader = this.$loading.show();
            const payload = this.coupon;
            await this.$store
                .dispatch(
                    this.propCoupon == undefined
                        ? "coupons/store"
                        : "coupons/update",
                    payload
                )
                .then((result) => {
                    // this.$emit("emitExit");
                    if (result.status != 201) {
                        this.exit();
                    }
                    this.$swal({
                        toast: true,
                        title: result.data.title,
                        icon: result.data.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            // loader.hide();
        },
        exit() {
            if (!this.propCoupon) {
                this.reset();
            }
            this.$emit("emitExit");
        },
        clickStart() {
            // this.fetch_category_goods();
        },
        setCoupon() {
            this.coupon = {
                id: this.propCoupon.id,
                title: this.propCoupon.title,
                minimum: this.propCoupon.minimum,
                maximum: this.propCoupon.maximum,
                percent: this.propCoupon.percent,
                date_start: this.propCoupon.date_start,
                date_end: this.propCoupon.date_end,
                limit_times: this.propCoupon.limit_times,
                customer_id: this.propCoupon.customer_id,
                remark: this.propCoupon.remark,
            };
        },

        async fetch_category_goods() {
            let loader = this.$loading.show();
            await this.$store
                .dispatch("posCategoryGoods/fetch")
                .then((result) => {
                    this.$swal({
                        toast: true,
                        title: result.data.title,
                        icon: result.data.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            loader.hide();
        },
    },
    async mounted() {
        if (this.propCoupon) {
            await this.setCoupon();
        }
        // await this.fetch_category_goods();
    },

    computed: {
        ...mapGetters({
            // category_goods: "posCategoryGoods/fetch",
        }),
        computedDateStartFormatted() {
            return this.formatDate(this.coupon.date_start);
        },
        computedDateEndFormatted() {
            return this.formatDate(this.coupon.date_end);
        },
    },
};
</script>
