<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="8">
                <v-text-field
                    dense
                    label="ค้นหาชื่อประเภท"
                    outlined
                    hide-details
                    prepend-inner-icon="search"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col md="8" cols="4">
                <div class="flex-row d-flex align-center justify-end">
                    <createCategoryGoods
                        @emitExit="emitExit"
                    ></createCategoryGoods>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :items="categoryGoods"
            :headers="headers"
            mobile-breakpoint="0"
            hide-default-footer
            :search="search"
        >
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
                <updateCategoryGoods
                    :propCategoryGoods="item"
                    @emitExit="emitExit()"
                ></updateCategoryGoods>
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
import createCategoryGoods from "@/js/components/pos/goods/categoryGoods/create";
import updateCategoryGoods from "@/js/components/pos/goods/categoryGoods/update";

export default {
    components: {
        createCategoryGoods,
        updateCategoryGoods,
    },
    data() {
        return {
            search: "",
            headers: [
                { text: "ชื่อประเภท", align: "start", value: "text" },
                { text: "สถานะสินค้า", value: "status_use", align: "center" },
                { text: "", value: "manages", align: "end" },
            ],
        };
    },
    methods: {
        async emitExit() {
            this.fetch_categort_goods();
        },
        async clickSwitchStatusUse(e) {
            let loader = this.$loading.show();
            const payload = {
                id: e,
            };
            await this.$store
                .dispatch("posCategoryGoods/updateStatusUse", payload)
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
        async fetch_categort_goods() {
            let loader = this.$loading.show();
            const payload = "sortUpdatedAt=DESC";
            await this.$store
                .dispatch("posCategoryGoods/fetch", payload)
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
        await this.fetch_categort_goods();
    },
    computed: {
        ...mapGetters({
            categoryGoods: "posCategoryGoods/fetch",
        }),
    },
};
</script>

<style></style>
