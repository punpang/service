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
                        <CostSub :sum="this.sum"></CostSub>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>
                        ยืนยันการชำระเงิน (ที่นี่)
                    </v-card-title>
                    <v-divider class="mt-0"></v-divider>
                    <v-card-text class="pt-0">
                        <v-form v-if="show" ref="form" lazy-validation>
                            <v-alert type="warning" class="ma-0">
                                โปรดชำระเงินขั้นต่ำด้วยยอด {{ amount }} บาท
                            </v-alert>
                            <v-row>
                                <v-col cols="12" md="6" class="pt-5">
                                    <v-img
                                        src="https://apply.scb.co.th/selfservices/easy-lg/common/img/logo-scb-w.png"
                                    ></v-img>
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
                                            พรรษิษฐ์ ศรีสุข
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6" md="6">
                                            เลขที่บัญชี
                                        </v-col>
                                        <v-col
                                            cols="6"
                                            md="6"
                                            class="text-right"
                                        >
                                            408-672-0266
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
                                class="mb-4"
                            ></v-file-input>

                            <v-img :src="previewSlip" class="mb-4"></v-img>

                            <v-btn
                                color="success"
                                large
                                block
                                @click="clickSubmit"
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
                </v-card>
            </v-col>
        </v-row>

        <v-alert type="error" v-else>
            ไม่มีสิทธิ์เข้าถึงการใช้งาน กรุณาติดต่อทางร้านค่ะ โทร.091-885-3402
        </v-alert>
        <overlay :overlay="overlay"></overlay>
    </div>
</template>

<script>
import overlay from "@/js/layouts/overlay";
import CostSub from "@/js/components/orders/details/CostSub";
import OrderDetail from "@/js/components/orders/details/detailNotFB";
export default {
    components: {
        CostSub,
        OrderDetail,
        overlay
    },
    data() {
        return {
            token: "",
            amount: "",
            previewSlip: "",
            show: true,
            verity: true,
            sum: {},
            overlay: false,
            slipFile: {},
            order: {
                customer_not_f_b: {
                    name: "",
                    phone: ""
                },
                order_status: {
                    name: ""
                }
            }
        };
    },
    methods: {
        onFileChange(image) {
            this.slipFile = event.target.files[0];
            this.previewSlip = URL.createObjectURL(image);
        },
        async clickSubmit() {
            this.overlay = true;
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
            this.overlay = false;
        }
    },
    async created() {
        this.token = this.$route.params.token;
        this.amount = this.$route.params.amount;
        const response = await axios.get(
            "/api/v1/guest/order/" + this.token + "/payment/alert"
        );
        if (response.status == 200) {
            this.order = response.data.data;
            //this.form.order_id = this.order.id
            this.sum = response.data.sum;
            this.verity = true;
        }else{
            this.verity = false;
        }
        
    }
};
</script>

<style></style>
