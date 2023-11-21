<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="9">
                <v-text-field
                    dense
                    label="ค้นหาคูปอง"
                    outlined
                    hide-details
                    prepend-inner-icon="search"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col md="8" cols="3">
                <div class="d-flex justify-end">
                    <createCoupon @emitExit="emitExit"></createCoupon>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>

        <v-data-table
            :items="coupons"
            :headers="headers"
            mobile-breakpoint="0"
            hide-default-footer
            :search="search"
            :items-per-page="99"
        >
            <template v-slot:item.date_start="{ item }">
                {{ item.date_start_th }}
            </template>

            <template v-slot:item.date_end="{ item }">
                {{ item.date_end_th }}
            </template>

            <template v-slot:item.status="{ item }">
                <v-btn class="success" small>ใช้งานอยู่</v-btn>
                <v-btn class="error" small>เลิกใช้งาน</v-btn>
            </template>
            
            <template v-slot:item.mimaxper="{ item }">
                {{ item.minimum }}/{{ item.maximum }}/{{ item.percent }}
            </template>

            <template v-slot:item.usedlimit="{ item }">
                {{ item.used_times }}/{{ item.limit_times }}
            </template>

            <template v-slot:item.manages="{ item }">
                <div class="flex-row d-flex justify-end">
                    <updateCoupon
                        :propCoupon="item"
                        @emitExit="emitExit"
                    ></updateCoupon>
                </div>
            </template>
        </v-data-table>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
import { mapGetters } from "vuex";
import createCoupon from "@/js/pages/coupons/create";
import updateCoupon from "@/js/pages/coupons/update";
import selectForOrder from "@/js/components/pos/goods/selectForOrder/create";
import btnLinkRawMaterials from "@/js/components/pos/goods/link_raw_materials/btn";
export default {
    props: ["propPosGoods"],
    components: {
        createCoupon,
        updateCoupon,
        selectForOrder,
        btnLinkRawMaterials,
    },
    data() {
        return {
            search: "",
            headers: [
                { text: "ชื่อคูปอง", align: "start", value: "title" },
                { text: "โค้ดคูปอง", value: "code" },
                { text: "วันเริ่มต้น", value: "date_start", align: "end" },
                { text: "วันหมดอายุ", value: "date_end", align: "end" },
                { text: "mi/max/percent", value: "mimaxper", align: "center" },
                { text: "used/limit", value: "usedlimit", align: "center" },
                { text: "", value: "manages", align: "end" },
            ],
        };
    },
    methods: {
        async emitFetchGoods() {
            await this.fetch_goods();
        },
        async emitExit() {
            // console.log("fdsjklo");
            await this.fetch_goods();
        },
        async clickSwitchStatusUse(e) {
            let loader = this.$loading.show();
            const payload = {
                id: e,
            };
            await this.$store
                .dispatch("posGoods/updateStatusUse", payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        icon: response.icon,
                        title: response.title,
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: "bottom",
                    });
                })
                .catch((error) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาดบางประการ",
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: "bottom",
                    });
                });
            loader.hide();
        },
        async fetch_goods() {
            let loader = this.$loading.show();
            const payload = "sortByDateStart=DESC";
            await this.$store
                .dispatch("coupons/fetch", payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        title: "โหลดข้อมูลสำเร็จ",
                        icon: "success",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                    });
                })
                .catch(() => {
                    this.$swal({
                        toast: true,
                        title: "เกิดข้อผิดพลาด",
                        icon: "error",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                    });
                });
            loader.hide();
        },
    },
    async mounted() {
        await this.fetch_goods();
    },
    computed: {
        ...mapGetters({
            coupons: "coupons/fetch",
        }),
    },
};
</script>

<style></style>
