<template>
    <div>
        <v-card>
            <!-- <v-card-title class="text-h6 white--text warning"></v-card-title> -->
            <v-card-text class="pt-3 pb-0">
                <p class="text-h6 font-weight-black">{{ propGoods.text }}</p>
                <v-text-field
                    label="ราคา(฿)"
                    outlined
                    hide-details
                    pattern="\d*"
                    type="number"
                    v-model="price"
                    suffix="บาท"
                    class="mb-2"
                ></v-text-field>
                <v-text-field
                    label="หมายเหตุ"
                    outlined
                    hide-details
                    v-model="note"
                ></v-text-field>
                <v-container class="mt-2">
                    <v-row>
                        <v-col
                            cols="5"
                            md="5"
                            class="d-flex align-center justify-end"
                        >
                            <v-btn
                                :disabled="quantity <= 1"
                                icon
                                fab
                                small
                                outlined
                                @click="clickDown()"
                            >
                                <v-icon>remove</v-icon>
                            </v-btn>
                        </v-col>
                        <v-col
                            cols="2"
                            md="2"
                            class="text-h6 d-flex px-0 align-center justify-center font-weight-black"
                        >
                            {{ quantity }}
                        </v-col>
                        <v-col
                            cols="5"
                            md="5"
                            class="d-flex align-center justify-start"
                        >
                            <v-btn icon fab small outlined @click="clickUp()">
                                <v-icon>add</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions v-if="option.status == 'update'">
                <v-btn
                    text
                    class="deep-orange--text"
                    block
                    large
                    @click="clickDelete()"
                >
                    ลบรายการนี้
                </v-btn>
            </v-card-actions>
            <v-card-actions>
                <v-btn
                    class="deep-orange"
                    dark
                    block
                    large
                    @click="clickSave()"
                >
                    บันทึก ({{ total | formatNumber }}฿)
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    props: ["propGoods", "propPosGoods"],
    data() {
        return {
            quantity: 1,
            price: 0,
            note: "",
            options: [
                {
                    id: 1,
                    text: "pos_add_goods_order",
                    status: "create",
                    dispatch: "posOrder/store",
                },
                {
                    id: 2,
                    text: "pos_update_goods_order",
                    status: "update",
                    dispatch: "posOrder/update",
                },
                {
                    id: 3,
                    text: "pos_add_goods_order_detail",
                    status: "create",
                    dispatch: "posOrderDetail/store",
                },
                {
                    id: 4,
                    text: "pos_update_goods_order_detail",
                    status: "update",
                    dispatch: "posOrderDetail/update",
                },
            ],
            option: {},
        };
    },
    methods: {
        async clickSave() {
            if (
                this.quantity <= 0 ||
                this.price < 0 ||
                this.price == "" ||
                this.pos_goods_id == ""
            ) {
                this.$swal({
                    toast: true,
                    title: "กรอกข้อมูลให้ครบถ้วน",
                    icon: "warning",
                    allowOutsideClick: false,
                    timer: 3000,
                    timerProgressBar: true,
                    position: "bottom",
                    showConfirmButton: false,
                });
                return;
            }
            let loader = this.$loading.show();
            let payload = {
                quantity: this.quantity,
                price: this.price,
                note: this.note,
                pos_goods_id: this.propGoods.id,
                total: this.total,
            };

            if (this.option.status == "create") {
                if (this.propPosGoods.order_id) {
                    payload.order_id = this.propPosGoods.order_id;
                }
                if (this.propPosGoods.order_detail_id) {
                    payload.order_id = this.propPosGoods.order_detail_id;
                }
            }

            if (this.option.status == "update") {
                payload.id = this.propPosGoods.propOrderGoods.id;
            }

            // if (this.propOrderUpdate) {
            //     payload.id = this.propOrderUpdate.id;
            //     dispatch = "orderPos/update";
            // }

            // if (this.propOrderDetail) {
            //     payload.order_detail_id = this.propOrderDetail.id;
            //     dispatch = "orderDetailPos/store";
            // }

            // if (this.propOrderDetailUpdate) {
            //     payload.id = this.propOrderDetailUpdate.id;
            //     dispatch = "orderDetailPos/update";
            // }

            if (this.option.dispatch == null) {
                return;
            }

            await this.$store
                .dispatch(this.option.dispatch, payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        title: response.title,
                        icon: response.icon,
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });

                    if (this.option.status == "create") {
                        this.price = this.propGoods.price;
                        this.quantity = 1;
                        this.note = "";
                    }

                    this.$emit("emitExit");
                })
                .catch((error) => {
                    this.$swal({
                        toast: true,
                        title: "มีบางอย่างผิดพลาด",
                        icon: "error",
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });
                });

            loader.hide();
        },
        async clickDelete() {
            const payload = {
                id: this.propPosGoods.propOrderGoods.id,
            };
            let dispatch = "";

            if (this.option.text == "pos_update_goods_order") {
                dispatch = "posOrder/delete";
            }

            this.$swal({
                title: "ต้องการลบรายการนี้ใช่ไหม ?",
                icon: "warning",
                allowOutsideClick: false,
                confirmButtonColor: "#38c172",
                confirmButtonText: "ใช่, ลบเลย",
                denyButtonText: "ไม่ใช่, ออก",
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let loader = this.$loading.show();
                    this.processingDelete(dispatch, payload);
                    loader.hide();
                }
            });
            return;
        },
        async processingDelete(dispatch, payload) {
            await this.$store
                .dispatch(dispatch, payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        title: response.title,
                        icon: response.icon,
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });

                    this.$emit("emitExit");
                })
                .catch((error) => {
                    this.$swal({
                        toast: true,
                        title: "มีบางอย่างผิดพลาด",
                        icon: "error",
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });
                });
        },
        clickDown() {
            if (this.quantity <= 1) {
                return;
            }
            this.quantity--;
        },
        clickUp() {
            this.quantity++;
        },
        start() {
            if (this.propPosGoods) {
                this.selectOption();
            }
            if (this.option.status == "update") {
                this.price = this.propPosGoods.propOrderGoods.price;
                this.note = this.propPosGoods.propOrderGoods.note;
                this.quantity = this.propPosGoods.propOrderGoods.quantity;
            } else {
                this.price = this.propGoods.price;
            }
        },
        selectOption() {
            const e = this.options.filter((e) => {
                return e.text == this.propPosGoods.text;
            });
            [this.option] = e;
        },
    },
    mounted() {
        this.start();
    },
    watch: {
        propPosGoods() {

            this.price = this.propPosGoods.propOrderGoods.price;
            this.note = this.propPosGoods.propOrderGoods.note;
            this.quantity = this.propPosGoods.propOrderGoods.quantity;
        },

        // price() {
        //     if (this.option.status == "update") {
        //         return this.propPosGoods.propOrderGoods.price;
        //     }
        //     return this.propGoods.price;
        // },
        // quantity() {
        //     if (this.option.status == "update") {
        //         return this.propPosGoods.propOrderGoods.quantity;
        //     }
        //     return 1;
        // },
        // note() {
        //     if (this.option.status == "update") {
        //         return this.propPosGoods.propOrderGoods.note;
        //     }
        //     return "";
        // },
    },
    computed: {
        total() {
            return this.price * this.quantity;
        },
    },
};
</script>

<style></style>
