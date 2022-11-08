<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="deep-orange" dark @click="clickStart()">
                    <v-icon left> add</v-icon>
                    สร้างสินค้า
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    สร้างสินค้า
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-5">
                    <v-text-field
                        outlined
                        label="ชื่อสินค้า"
                        hide-details
                        class="mb-3"
                        v-model="goods.text"
                    ></v-text-field>
                    <v-text-field
                        pattern="\d*"
                        type="number"
                        outlined
                        label="ราคา"
                        hide-details
                        class="mb-3"
                        suffix="บาท"
                        v-model="goods.price"
                    ></v-text-field>
                    <v-select
                        outlined
                        label="ประเภท"
                        hide-details
                        class="mb-3"
                        :items="category_goods"
                        item-text="text"
                        item-value="id"
                        v-model="goods.pos_category_goods_id"
                    ></v-select>
                    <v-switch
                        outlined
                        label="สถานะใช้งาน"
                        hide-details
                        class="mb-3"
                        v-model="goods.status_use"
                    ></v-switch>
                </v-card-text>
                <v-card-actions>
                    <v-btn class="error">
                        <v-icon left>exit_to_app</v-icon> ออก
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="orange" dark @click="clickSave()">
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            dialog: false,
            goods: {
                text: "",
                price: "",
                status_use: 1,
                pos_category_goods_id: "",
            },
        };
    },
    methods: {
        reset() {
            this.goods = {
                text: "",
                price: "",
                status_use: 1,
                pos_category_goods_id: "",
            };
        },
        async clickSave() {
            let loader = this.$loading.show();
            const payload = this.goods;
            await this.$store
                .dispatch("posGoods/store", payload)
                .then((result) => {
                    this.$emit("emitExit");
                    this.exit();
                    this.$swal({
                        toast: true,
                        title: result.data.title,
                        icon: result.data.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            loader.hide();
        },
        exit() {
            this.reset();
            this.dialog = false;
        },
        clickStart() {
            this.fetch_category_goods();
        },
        async fetch_category_goods() {
            let loader = this.$loading.show();
            await this.$store
                .dispatch("posCategoryGoods/fetch")
                .then((result) => {
                    this.$swal({
                        toast: true,
                        title: result.data.title,
                        icon: result.data.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            loader.hide();
        },
    },
    computed: {
        ...mapGetters({
            category_goods: "posCategoryGoods/fetch",
        }),
    },
};
</script>

<style></style>
