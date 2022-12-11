<template>
    <div>
        <div v-if="is_show">
            <v-card outlined class="mb-2">
                <v-card-title class="text-h6 pb-1">
                    หมายเลขคำสั่งซื้อ #{{ order.id }}
                </v-card-title>
                <v-card-text>
                    <div class="d-flex flex-row mb-1">
                        <div class="font-weight-bold mr-2">ชื่อลูกค้า</div>
                        <div class="text-secondary">
                            {{ order.customer.name }}
                        </div>
                    </div>
                    <div class="d-flex flex-row mb-1">
                        <div class="font-weight-bold mr-2">เบอร์โทรศัพท์</div>
                        <div class="text-secondary">
                            {{ order.customer.tel }}
                        </div>
                    </div>
                    <div class="d-flex flex-row mb-1">
                        <div class="font-weight-bold mr-2">
                            วัน-เวลานัดรับสินค้า
                        </div>
                        <div class="text-secondary">
                            {{ order.date_get_th }}
                            {{ order.time_get_format }} น.
                        </div>
                    </div>
                    <v-btn
                        outlined
                        small
                        class="mt-2"
                        color="info"
                        @click="clickToOrder()"
                        >รายละเอียด</v-btn
                    >
                </v-card-text>
            </v-card>

            <v-card outlined class="mb-2">
                <v-card-title class="text-h6"
                    >{{
                        order.sum_all.sumBalance == 0
                            ? "ยอดรวมทั้งหมด"
                            : "ยอดคงเหลือ"
                    }}
                    <v-spacer></v-spacer>
                    {{ order.sum_all.sumBalance | formatNumber }}
                    บาท</v-card-title
                >
            </v-card>

            <v-card outlined>
                <v-card-title class="text-h6">
                    อัปโหลดสลิปหลังโอนชำระเงิน
                </v-card-title>
                <v-card-text>
                    <uploadImage
                        :propUploadImange="uploadImange"
                        :propLabel="'กดที่นี่ เพื่ออัปโหลดสลิป'"
                        @emitImageId="emitImageId"
                    ></uploadImage>
                    <v-alert color="warning" class="mb-0 mt-2" dark dense>
                        <strong class="mb-0 text-caption"
                            >จำเป็นต้องแนบสลิป หลังจากชำระเงิน</strong
                        >
                    </v-alert>

                    <cardFormDetailBank></cardFormDetailBank>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});

import cardPaymentSummary from "@/js/components/order/cardPaymentSummary";
import cardFormDetailBank from "@/js/components/guest/cardFormDetailBank";
import uploadImage from "@/js/components/google/drive/uploadImage";
export default {
    components: { uploadImage, cardFormDetailBank, cardPaymentSummary },
    data() {
        return {
            uploadImange: { imagePreview: "", file: null },
            order: {},
            is_show: false,
        };
    },
    methods: {
        clickToOrder() {
            window.location.href = `/o/${this.$route.params.uuid}`;
        },
        async emitImageId(response) {
            if (response.status == 200) {
                const data = response.data;
                const payload = {
                    uuid: this.$route.params.uuid,
                    src_name: data.image.src_name,
                    amount: this.order.sum_all.sumBalance,
                };

                let loader = this.$loading.show();
                const res = await this.$store.dispatch(
                    `orderNoticeOfPaymentFromCustomer/createByUuid`,
                    payload
                );

                loader.hide();
                this.$swal({
                    title: res.data.message,
                    icon: "success",
                    allowOutsideClick: false,
                    confirmButtonText: "รับทราบ",
                }).then((response) => {
                    if (response.isConfirmed) {
                        let loader = this.$loading.show();
                        this.clickToOrder();
                    }
                });
            }
        },
    },
    async mounted() {
        let loader = this.$loading.show();
        await axios
            .get(`/api/v1/guest/check_uuid/${this.$route.params.uuid}`)
            .then((response) => {
                this.order = response.data.order;
                this.is_show = response.data.status;
            })
            .catch((error) => {
                console.log(error);
            });
        if (!this.is_show) {
            this.$swal({
                allowOutsideClick: false,
                title: "มีบางอย่างผิดพลาด",
                icon: "error",
                showConfirmButton: false,
            });
        }
        loader.hide();
    },
};
</script>

<style></style>
