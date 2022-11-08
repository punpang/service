<template>
    <div>
        <v-data-table :items="goodses" :headers="headers" mobile-breakpoint="0">
            <template v-slot:item.price="{ item }">
                {{ item.price | formatNumber }}
            </template>

            <template v-slot:item.category_goodses="{ item }">
                {{ item.category_goodses.text }}
            </template>

            <template v-slot:item.status_use="{ item }">
                <v-switch
                    outlined
                    label="สถานะสินค้า"
                    v-model="item.status_use"
                ></v-switch>
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
export default {
    data() {
        return {
            headers: [
                { text: "ชื่อสินค้า", align: "start", value: "text" },
                { text: "ประเภท", value: "category_goodses.text" },
                { text: "ราคา(฿)", value: "price", align: "end" },
                { text: "สถานะสินค้า", value: "status_use" },
                { text: "", value: "manages" },
            ],
        };
    },
    methods: {
        async fetch_goods() {
            const payload = "raw=true";
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
