<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="12">
                <v-text-field
                    dense
                    label="ค้นหาชื่อประเภท"
                    outlined
                    hide-details
                    prepend-inner-icon="search"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col md="8" cols="12">
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
                        :label="item.status_use ? 'ใช้งานอยู่' : 'ไม่ได้ใช้งาน'"
                        v-model="item.status_use"
                    ></v-switch>
                </div>
            </template>

            <template v-slot:item.manages="{ item }">
                <v-btn icon fab x-small>
                    <v-icon>more_vert</v-icon>
                </v-btn>
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

export default {
    components: {
        createCategoryGoods,
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
            await this.fetch_categort_goods();
        },
        async fetch_categort_goods() {
            let loader = this.$loading.show();
            const payload = "raw=true";
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
