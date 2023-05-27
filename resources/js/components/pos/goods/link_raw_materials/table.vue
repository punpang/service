<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="8">
                <v-text-field
                    dense
                    label="ค้นหาวัตถุดิบ"
                    outlined
                    hide-details
                    prepend-inner-icon="search"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col md="8" cols="4">
                <div class="flex-row d-flex align-center justify-end">
                    <!-- <createRawMaterial @emitExit="emitExit"></createRawMaterial> -->
                    <btnTableRawMaterial
                        :propGoods="propGoods"
                        @emitFetchGoods="emitFetchGoods"
                    ></btnTableRawMaterial>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :items="propGoods.pos_link_raw_materials"
            :headers="headers"
            mobile-breakpoint="0"
            hide-default-footer
            :search="search"
        >
            <template v-slot:item.price="{ item }">
                {{ item.price | formatNumber }}
                <!-- <div class="justify-center d-flex">
                    <v-switch
                        dense
                        inset
                        outlined
                        v-model="item.status_use"
                        @click="clickSwitchStatusUse(item.id)"
                    ></v-switch>
                </div> -->
            </template>
            <template v-slot:item.cost="{ item }">
                {{ item.cost | formatNumber }}
            </template>

            <template v-slot:item.weight="{ item }">
                {{ item.weight | formatNumber }}
            </template>

            <template v-slot:item.manages="{ item }">
                <div class="flex-row d-flex justify-end">
                    <updateLinkRawMaterial
                        :propLinkRawMaterial="item"
                        :propGoods="propGoods"
                        :propRawMaterial="item.raw_material"
                        @emitFetchGoods="emitFetchGoods"
                        @emitExit="emitExit()"
                    ></updateLinkRawMaterial>
                    <removeLinkRawMaterial
                        :propLinkRawMaterial="item"
                        @emitFetchGoods="emitFetchGoods"
                    ></removeLinkRawMaterial>
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
import updateLinkRawMaterial from "@/js/components/pos/goods/link_raw_materials/create";
import btnTableRawMaterial from "@/js/components/pos/goods/link_raw_materials/btnTableRawMaterial";
import removeLinkRawMaterial from "@/js/components/pos/goods/link_raw_materials/remove";

export default {
    props: ["propRawMaterials", "propGoods"],
    components: {
        updateLinkRawMaterial,
        btnTableRawMaterial,
        removeLinkRawMaterial,
    },
    data() {
        return {
            search: "",
            headers: [
                {
                    text: "ชื่อวัตถุดิบ",
                    align: "start",
                    value: "raw_material.text",
                },
                { text: "ต้นทุน", value: "cost", align: "center" },
                { text: "น้ำหนัก/ปริมาณ", value: "weight", align: "center" },
                { text: "", value: "manages", align: "end" },
            ],
        };
    },
    methods: {
        emitFetchGoods() {
            this.$emit("emitFetchGoods");
        },
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
                .dispatch("posRawMaterial/fetch", payload)
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
            rawMaterials: "posRawMaterial/fetch",
        }),
    },
};
</script>

<style></style>
