<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="9">
                <v-text-field
                    dense
                    label="ค้นหาชื่อสินค้า"
                    outlined
                    hide-details
                    prepend-inner-icon="search"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col md="8" cols="3">
                <div class="d-flex justify-end">
                    <createGoods @emitExit="emitExit"></createGoods>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :items="goodses"
            :headers="headers"
            mobile-breakpoint="0"
            hide-default-footer
            :search="search"
            :items-per-page="99"
        >
            <template v-slot:item.text="{ item }" class="mb-0 flex-row d-flex">
                <p class="mb-0 flex-row d-flex">
                    {{ item.text }}
                </p>
            </template>
            <template v-slot:item.price="{ item }">
                {{ item.price | formatNumber }} /
                {{ item.sum_cost_link_raw_material | formatNumber }} /
                {{
                    (item.price - item.sum_cost_link_raw_material)
                        | formatNumber
                }}
            </template>

            <template v-slot:item.category_goodses="{ item }">
                {{ item.category_goodses.text }}
            </template>

            <template v-slot:item.status_use="{ item }">
                <div class="justify-center d-flex">
                    <v-switch
                        dense
                        inset
                        outlined
                        v-model="item.status_use"
                        @click="clickSwitchStatusUse(item.id)"
                    ></v-switch>
                </div>
            </template>

            <template v-slot:item.manages="{ item }">
                <div class="flex-row d-flex justify-end">
                    <selectForOrder
                        :propGoods="item"
                        :propPosGoods="propPosGoods"
                        v-if="propPosGoods"
                    ></selectForOrder>
                    <selectForProductInterest
                        v-if="propSelectForProductInterest"
                        @emitAddGoodsProductInterest="
                            emitAddGoodsProductInterest
                        "
                        :propGoods="item"
                    ></selectForProductInterest>
                    <btnLinkRawMaterials
                        :propGoods="item"
                        @emitExit="emitExit"
                        @emitFetchGoods="emitFetchGoods"
                    ></btnLinkRawMaterials>
                    <updateGoods
                        :propGoods="item"
                        @emitExit="emitExit"
                    ></updateGoods>
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
import createGoods from "@/js/components/pos/goods/create";
import updateGoods from "@/js/components/pos/goods/update";
import selectForOrder from "@/js/components/pos/goods/selectForOrder/create";
import selectForProductInterest from "@/js/pages/product_interest/btnSelectGoods";

import btnLinkRawMaterials from "@/js/components/pos/goods/link_raw_materials/btn";
export default {
    props: ["propPosGoods", "propSelectForProductInterest"],
    components: {
        createGoods,
        updateGoods,
        selectForOrder,
        btnLinkRawMaterials,
        selectForProductInterest,
    },
    data() {
        return {
            search: "",
            headers: [
                { text: "ชื่อสินค้า", align: "start", value: "text" },
                { text: "ประเภท", value: "category_goodses.text" },
                { text: "ขาย/ต้นทุน/กำไร", value: "price", align: "end" },
                { text: "สถานะสินค้า", value: "status_use", align: "center" },
                { text: "", value: "manages", align: "end" },
            ],
        };
    },
    methods: {
        emitAddGoodsProductInterest(propGoods) {
            this.$emit("emitAddGoodsProductInterest", propGoods);
        },
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
            const payload =
                "with=categoryGoodses,posLinkRawMaterials.rawMaterial&sortUpdatedAt=DESC";
            await this.$store
                .dispatch("posGoods/fetch", payload)
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
            goodses: "posGoods/fetch",
        }),
    },
};
</script>

<style></style>
