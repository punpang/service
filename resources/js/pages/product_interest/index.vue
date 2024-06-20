<template>
    <div>
        <v-row class="mt-1">
            <v-col cols="12" md="9">
                <v-text-field
                    hide-details
                    label="ค้นหาชื่อสินค้า"
                    outlined
                    class="small"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <register @emitFetch="emitFetch"></register>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :headers="headers"
            :items="goods"
            :search="search"
            hide-default-footer
            :items-per-page="-1"
        >
            <template v-slot:item.sms_alert="{ item }">
                <v-btn
                    v-on="on"
                    class="info"
                    @click="setGoodsForSMSAlert(item)"
                >
                    <v-icon left>sms</v-icon>
                    ส่ง SMS แจ้งลูกค้า
                </v-btn>
            </template></v-data-table
        >
    </div>
</template>

<script>
import register from "@/js/pages/product_interest/register";
export default {
    components: {
        register,
    },
    data() {
        return {
            dialog: false,
            search: "",
            goods: [],
            headers: [
                { text: "ชื่อสินค้า", value: "text" },
                { text: "จำนวนที่สนใจ", value: "count_product_interest" },
                { text: "แจ้งเตือน", align: "end", value: "sms_alert" },
            ],
            set_goods: {},
        };
    },
    methods: {
        emitFetch(){
            this.fetch()
        },
        clickExit() {
            this.dialog = false;
        },
        setGoodsForSMSAlert(goods) {
            this.$swal({
                title: goods.text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "ส่งข้อความ",
                cancelButtonText: "ออก",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.clickSendSMS();
                }
            });
            this.set_goods = goods;
        },
        async fetch() {
            let loader = this.$loading.show();

            await axios
                .get("/api/admin/v1/product_interest/fetch")
                .then((response) => {
                    this.goods = response.data.goods;
                    this.$swal({
                        title: response.data.title,
                        toast: true,
                        icon: response.data.icon,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: "3000",
                        timerProgressBar: true,
                    });
                })
                .catch((error) => {
                    this.$swal({
                        title: "เกิดข้อผิดพลาดบางประการ",
                        toast: true,
                        icon: "error",
                        showConfirmButton: false,
                        position: "bottom",
                        timer: "3000",
                        timerProgressBar: true,
                    });
                });

            loader.hide();
        },

        async clickSendSMS() {
            let loader = this.$loading.show();

            await axios
                .post(
                    `/api/admin/v1/product_interest/${this.set_goods.id}/alert_to_customer`
                )
                .then((response) => {
                    this.fetch();
                })
                .catch((error) => {
                    this.$swal({
                        title: "เกิดข้อผิดพลาดบางประการ",
                        toast: true,
                        icon: "error",
                        showConfirmButton: false,
                        position: "bottom",
                        timer: "3000",
                        timerProgressBar: true,
                    });
                });

            loader.hide();
        },
    },
    async mounted() {
        await this.fetch();
    },
};
</script>

<style></style>
