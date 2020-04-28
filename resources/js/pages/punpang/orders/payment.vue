<template>
    <div>
        <v-row>
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
                    <v-card-text class="py-0">
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
                                    <v-col cols="6" md="6" class="text-right">
                                        พรรษิษฐ์ ศรีสุข
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="6" md="6">
                                        เลขที่บัญชี
                                    </v-col>
                                    <v-col cols="6" md="6" class="text-right">
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
                        ></v-file-input>
                        <v-img :src="previewSlip" hidden></v-img>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import CostSub from "@/js/components/orders/details/CostSub";
import OrderDetail from "@/js/components/orders/details/detailNotFB";
export default {
    components: {
        CostSub,
        OrderDetail
    },
    data() {
        return {
            token: "",
            amount: "",
            previewSlip: "",
            sum: {},
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
            this.previewSlip = URL.createObjectURL(image);
        }
    },
    async created() {
        this.token = this.$route.params.token;
        this.amount = this.$route.params.amount;
        const { data } = await axios.get(
            "/api/v1/guest/order/" + this.token + "/payment/alert"
        );
        this.order = data.data;
        this.sum = data.sum;
    }
};
</script>

<style></style>
