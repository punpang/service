<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                แจ้งชำระเงิน</v-card-title
            >
            <v-card-text>
                <v-simple-table>
                    <tbody>
                        <tr>
                            <td>
                                <strong>
                                    {{ text.order.number }}
                                </strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ order.id }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                        <tr>
                            <td>
                                <strong>วัน-เวลานัดรับสินค้า</strong>
                            </td>
                            <td class="text-right">
                                <strong
                                    >{{ order.date_get }}
                                    {{ order.time_get }}</strong
                                >
                            </td>
                        </tr>
                        <!-- / -->
                    </tbody>
                </v-simple-table>
            </v-card-text>
        </v-card>

        <v-card outlined class="mb-2">
            <v-card-title class="text-h6 white--text warning">
                กำหนดวัน-เวลาชำระเงิน
            </v-card-title>
            <v-card-text>
                <v-item class="my-3">
                    <v-card class="d-flex align-center" outlined height="50">
                        <div class="text-h5 flex-grow-1 text-center">
                            {{ this.dateTimeForPay }}
                        </div>
                    </v-card>
                </v-item>

                <v-item-group>
                    <v-container>
                        <v-row>
                            <v-col
                                v-for="option in timeOptions"
                                :key="option.id"
                                cols="6"
                                class="p-1"
                                lg="3"
                                md="4"
                            >
                                <v-item
                                    v-slot="{ active, toggle }"
                                    @change="changeTimeOption(option)"
                                    v-clipboard:copy="detailText()"
                                    v-clipboard:success="onCopy"
                                >
                                    <v-card
                                        :color="
                                            active
                                                ? 'teal darken-1'
                                                : 'grey lighten-4'
                                        "
                                        class="d-flex align-center"
                                        height="50"
                                        @click="toggle"
                                    >
                                        <v-scroll-y-transition>
                                            <div
                                                v-if="active"
                                                class="flex-grow-1 text-center white--text"
                                            >
                                                <strong>{{
                                                    option.text
                                                }}</strong>
                                            </div>
                                            <div
                                                v-else
                                                class="flex-grow-1 text-center black--text"
                                            >
                                                <strong>
                                                    {{ option.text }}
                                                </strong>
                                            </div>
                                        </v-scroll-y-transition>
                                    </v-card>
                                </v-item>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-item-group>

                <!-- <v-chip-group column mandatory active-class="primary--text">
          <v-chip
            large
            label
            v-for="option in timeOptions"
            :key="option.id"
            @click="clickTimeOption(option)"
          >
            {{ option.text }}
          </v-chip>
        </v-chip-group> -->
            </v-card-text>
        </v-card>

        <v-card>
            <v-card-title class="text-h6 white--text warning">
                ข้อบังคับ
            </v-card-title>
            <v-card-text>
                <v-checkbox
                    :disabled="
                        order.sum_all.sumMoneyCustomer > 0 ||
                        this.order.order_delivery_service != undefined
                    "
                    v-model="status_full_payment"
                    label="แจ้งชำระเงินเต็มจำนวน"
                    hide-details
                ></v-checkbox>
                <!-- <v-checkbox
                    v-model="alertSMSToCustomer"
                    label="แจ้งเตือนลูกค้า (SMS)"
                    hide-details
                ></v-checkbox> -->
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <!-- <v-btn large dark class="success">
          <v-icon left>notifications</v-icon>
          <strong>แจ้งเตือนชำระเงิน</strong>
        </v-btn> -->
                <v-btn large class="error" @click="exit()">
                    <v-icon left>exit_to_app</v-icon>
                    <strong>ออก</strong>
                </v-btn>
                <v-btn
                    class="success"
                    large
                    :disabled="dateTimeForPay == ''"
                    @click="clickAlertPaymentByOrderID"
                >
                    <v-icon left>notifications</v-icon>
                    <strong>แจ้งชำระเงิน</strong>
                </v-btn>
            </v-card-actions>
        </v-card>

        <!-- <v-textarea label="ทดสอบ" outlined v-model="detailText"></v-textarea>
        {{ detailText() }} -->

        <!-- {{ detailText() }} -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            timeOptions: [
                { id: 1, text: "15 นาที", status_use: 1 },
                { id: 2, text: "30 นาที", status_use: 1 },
                { id: 3, text: "1 ชั่วโมง", status_use: 1 },
                { id: 4, text: "3 ชั่วโมง", status_use: 1 },
                { id: 5, text: "6 ชั่วโมง", status_use: 1 },
                { id: 7, text: "12 ชั่วโมง", status_use: 1 },
                { id: 8, text: "24 ชั่วโมง", status_use: 1 },
                { id: 6, text: "ก่อนวันรับสินค้า", status_use: 1 },
            ],
            dateTimeForPay: "",
            status_full_payment: 0,
            alertSMSToCustomer: 1,
        };
    },
    methods: {
        async clickAlertPaymentByOrderID() {
            let loader = this.$loading.show();
            const payload = {
                orderID: this.order.id,
                payment_deadline: this.dateTimeForPay,
                status_full_payment: this.status_full_payment,
            };

            const result = await this.$store.dispatch(
                "orderIndex/alertPaymentByOrderID",
                payload
            );
            if (result.status == 200) {
                this.$toast.success("แจ้งเตือนชำระเงินสำเร็จ");
                this.exit();
            } else {
                this.$toast.error("แจ้งเตือนชำระเงินไม่สำเร็จ");
            }

            // this.dateTimeForPay = "";
            // this.status_full_payment = 0;
            // this.alertSMSToCustomer = 1;

            loader.hide();
        },
        exit() {
            this.$emit("emitAlertPayment");
        },
        detailText() {
            // return "test TEXT";
            // let detail = "";
            //   if (
            //     this.order.m1 === 99 ||
            //     this.order.m2 === 99 ||
            //     this.order.m3 === 99 ||
            //     this.order.m4 === 99
            //   ) {
            //     detail = "";
            //   } else {
            //     detail = `${this.order.am1.m1}:${this.order.am2.m2}:${this.order.am3.m3}:${this.order.am4.m4}`;
            //   }

            // let other = `\nthis.order.other`;
            // if (this.order.other === "-") {
            //     other = "";
            // }

            // let message = `\n\n📌 เขียนข้อความ\n${this.order.msg}`;
            // if (this.order.msg === "-") {
            //     message = "";
            // }

            // let sumUp = this.order.total + this.order.add;

            return `
      📌 หมายเลขคำสั่งซื้อ #${this.order.id}\n\n📌ข้อมูลลูกค้า\nคุณ ${this.order.customer.name}\nหมายเลขโทรศัพท์ ${this.order.customer.tel}\n\n📌 วัน-เวลานัดรับสินค้า\n${this.order.date_get} ${this.order.time_get}\n\n📌 ยอดรวมทั้งหมด ${this.order.sum_all.sumTASC} บาท\n\n📌 โปรดชำระเงินภายใน\n${this.dateTimeForPay} น.\n\n📌 วิธีชำระเงิน\nกดที่ลิงก์เพื่อตรวจสอบรายละเอียดและชำระเงินด้านในลิงก์ ${window.location.hostname}/o/${this.order.auth_order}\n\n❗️❗️ชำระเงินผ่านระบบหน้าเว็บเท่านั้น❗️❗️
      `;

            //         return `
            //   📌 หมายเลขคำสั่งซื้อ #${this.order.id}\n\n📌ข้อมูลลูกค้า\nคุณ ${this.order.customer.name}\nหมายเลขโทรศัพท์ ${this.order.customer.tel}\n\n📌 วัน-เวลานัดรับสินค้า\n${this.order.date_get} ${this.order.time_get}\n\n📌 รายละเอียดรายการสั่งซื้อ\n${detail}${other}${message}\n\n📌 ยอดรวมทั้งหมด ${sumUp} บาท\n\n📌 โปรดชำระเงินภายใน\n${this.dateTimeForPay}\n\n📌 วิธีชำระเงิน\nกดที่ลิงก์เพื่อตรวจสอบรายละเอียดและชำระเงินด้านในลิงก์ http://192.168.1.103:8000/o/${this.order.auth_order}\n\n❗️❗️ชำระเงินผ่านระบบหน้าเว็บเท่านั้น❗️❗️
            //   `;
        },
        clickTimeOption(v) {
            const datetime = new Date();
            let oDateTime = new Date(this.formatDateTimeGetForAlert());


            switch (v.id) {
                case 1:
                    datetime.setMinutes(datetime.getMinutes() + 15);
                    break;
                case 2:
                    datetime.setMinutes(datetime.getMinutes() + 30);
                    break;
                case 3:
                    datetime.setMinutes(datetime.getMinutes() + 60);
                    break;
                case 4:
                    datetime.setMinutes(datetime.getMinutes() + 180);
                    break;
                case 5:
                    datetime.setMinutes(datetime.getMinutes() + 360);
                    break;
                case 7:
                    datetime.setMinutes(datetime.getMinutes() + 720);
                    break;
                case 8:
                    datetime.setMinutes(datetime.getMinutes() + 1440);
                    break;
                case 6:
                    oDateTime.setDate(oDateTime.getDate() - 2);
                    oDateTime.setHours(12);
                    oDateTime.setMinutes(0);
                    break;
            }

            if (v.id == 6) {
                this.dateTimeForPay = oDateTime.toLocaleString();
            } else {
                this.dateTimeForPay = datetime.toLocaleString();
            }
        },
        changeTimeOption(v) {
            this.clickTimeOption(v);
        },
        formatDateTimeGetForAlert() {
            const d = this.order.date_get;
            const [yyyy, mm, dd] = d.split("-");
            // const dd = arr[0];
            // const mm = arr[1];
            // const yyyy = parseInt(arr[2]) - 543;

            return `${yyyy}/${mm}/${dd}`;
        },
        formatDateTimeGet() {
            const d = this.order.date_get;
            const [yyyy, mm, dd] = d.split("-");
            // const dd = arr[0];
            // const mm = arr[1];
            // const yyyy = parseInt(arr[2]) - 543;

            return `${yyyy}/${mm}/${dd} ${this.order.time_get}:00`;
        },
        async start() {
            const res = await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });

            if (
                this.order.sum_all.sumMoneyCustomer > 0 ||
                this.order.order_delivery_service
            ) {
                this.status_full_payment = true;
            }
            // console.log(res);
        },
        onCopy() {
            // this.$swal({
            //     title: "คัดลอกแล้ว",
            //     icon: "success",
            //     allowOutsideClick: false,
            //     // timerProgressBar: true,
            //     // timer: 3000,
            //     confirmButtonText: "เรียบร้อย",
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         this.exit();
            //     }
            // });
            this.$swal({
                toast: true,
                timer: 3000,
                timerProgressBar: true,
                position: "bottom",
                icon: "success",
                title: "คัดลอกแล้ว",
                showConfirmButton: false,
            });
        },
    },
    async mounted() {
        await this.start();
        // await this.changeTimeOption(1);
    },
    computed: {
        ...mapGetters({
            text: "orderText/text",
            order: "orderIndex/order",
        }),
    },
};
</script>
