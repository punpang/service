<template>
    <div>
        <v-row v-if="verity">
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>
                        แจ้งชำระเงิน
                        <v-spacer></v-spacer>
                        #{{ order.id }}
                    </v-card-title>
                    <v-divider class="ma-0"></v-divider>
                    <v-card-text class="py-0">
                        <OrderDetail :order="order"></OrderDetail>
                        <v-divider class="ma-0"></v-divider>
                        <CostSub :sum="sum"></CostSub>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>
                        ยืนยันการชำระเงิน (ที่นี่)
                    </v-card-title>
                    <v-divider class="mt-0"></v-divider>
                    <v-card-text class="pt-0" v-if="sum.balance > 0">
                        <v-form v-if="show" ref="form" lazy-validation>
                            <v-alert type="warning" class="ma-0">
                                โปรดชำระเงินขั้นต่ำด้วยยอด {{ amount }} บาท
                            </v-alert>
                            <v-row>
                                <v-col cols="12" md="6" class="pt-5">
                                    <v-img :src="bank.book.logoBank"></v-img>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="6" md="6">
                                            ชื่อบัญชี
                                        </v-col>
                                        <v-col
                                            cols="6"
                                            md="6"
                                            class="text-right"
                                        >
                                            {{ bank.book.name }}
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="5" md="5">
                                            เลขที่บัญชี
                                        </v-col>
                                        <v-col
                                            cols="7"
                                            md="7"
                                            class="text-right"
                                        >
                                            <v-btn
                                                x-small
                                                icon
                                                color="primary"
                                                v-clipboard:copy="
                                                    bank.book.numberClipboard
                                                "
                                                v-clipboard:success="onCopy"
                                                fab
                                                
                                            >
                                                <v-icon>file_copy</v-icon>
                                            </v-btn>
                                            {{ bank.book.number }}
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-file-input
                                outlined
                                prepend-icon="image"
                                placeholder="แนบสลิปการชำระเงิน"
                                accept="image/*"
                                @change="onFileChange"
                                hide-details
                                :rules="[v => !!v]"
                            ></v-file-input>
                            <div v-if="previewSlip">
                                <v-divider></v-divider>
                                <v-img :src="previewSlip"></v-img>
                            </div>
                            <v-divider></v-divider>
                            <paymentConditions
                                :conditions="conditions"
                                @emitConditions="emitConditions"
                            ></paymentConditions>
                            <v-divider></v-divider>
                            <v-btn
                                color="success"
                                large
                                block
                                @click="clickSubmit"
                                :disabled="
                                    !conditions.deposit ||
                                        !conditions.dateTime_get ||
                                        !conditions.acceptAll || 
                                        !previewSlip
                                "
                            >
                                <v-icon left>cloud_upload</v-icon>
                                แจ้งชำระเงิน
                            </v-btn>
                        </v-form>
                        <v-alert v-else type="success" class="ma-0"
                            >ขอบคุณที่ชำระเงินค่ะ
                            เราจะตรวจสอบและแจ้งผลโดยเร็วที่สุดค่ะ</v-alert
                        >
                    </v-card-text>
                    <v-card-text v-else class="pt-0">
                        <v-alert type="success" class="ma-0"
                            >คุณได้ทำการชำระครบจำนวนแล้วค่ะ</v-alert
                        >
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-alert type="error" v-else>
            ไม่สามารถเข้าถึงเนื้อหาได้ กรุณาลองอีกครั้งภายหลัง หรือโทร.
            091-885-3402
        </v-alert>
        <overlay :overlay="overlay"></overlay>
        <snackbarRight :snackbar="snackbar"></snackbarRight>
    </div>
</template>

<script>
import overlay from "@/js/layouts/overlay";
import CostSub from "@/js/components/orders/details/CostSub";
import OrderDetail from "@/js/components/orders/details/detailNotFB";
import snackbarRight from "@/js/layouts/snackbarRight";
import paymentConditions from "@/js/pages/punpang/orders/paymentConditions";

export default {
    components: {
        CostSub,
        OrderDetail,
        overlay,
        snackbarRight,
        paymentConditions
    },
    data() {
        return {
            token: "",
            amount: "",
            previewSlip: "",
            show: true,
            verity: true,
            sum: {},
            snackbar: {},
            overlay: false,
            slipFile: {},
            conditions: {
                deposit: false,
                dateTime_get: false,
                acceptAll: false
            },
            order: {
                customer_not_f_b: {
                    name: "",
                    phone: ""
                },
                order_status: {
                    name: ""
                }
            },
            bank: {
                book: {
                    nameBank: "ธนาคารไทยพาณิชย์",
                    logoBank:
                        "https://apply.scb.co.th/selfservices/easy-lg/common/img/logo-scb-w.png",
                    name: "พรรษิษฐ์ ศรีสุข",
                    number: "408-672-0266",
                    numberClipboard: "4086720266"
                }
            }
        };
    },
    methods: {
        emitConditions(data) {
            this.conditions = data;
        },
        onFileChange(image) {
            this.slipFile = event.target.files[0];
            this.previewSlip = URL.createObjectURL(image);
        },
        onCopy() {
            this.snackbar = {
                status: true,
                color: "success",
                text: "คัดลอกแล้ว"
            };
        },
        async clickSubmit() {
            let loader = this.$loading.show();
            
            if (this.$refs.form.validate()) {
                const formData = new FormData();
                formData.append("image", this.slipFile);

                const res = await axios.post(
                    "/api/v1/guest/order/" +
                        this.token +
                        "/payment/alert/uploadslip",
                    formData
                );

                if (res.status === 200) {
                    this.show = false;
                }
            }
            loader.hide();
        },
        async start() {
            let loader = this.$loading.show();
            this.token = this.$route.params.token;
            this.amount = this.$route.params.amount;
            let response = "";
            try {
                response = await axios.get(
                    "/api/v1/guest/order/" + this.token + "/payment/alert"
                );
            } catch (res) {
                response = res;
            }

            if (response.status == 200) {
                this.order = response.data.data;
                //this.form.order_id = this.order.id
                this.sum = response.data.sum;
                this.verity = true;
            } else {
                this.verity = false;
            }
            loader.hide();
        }
    },
    async mounted() {
        this.start();
    }
};
</script>

<style></style>
