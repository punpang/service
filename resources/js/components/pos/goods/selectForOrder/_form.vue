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
                                :disabled="count <= 1"
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
                            {{ count }}
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
            <v-card-actions
                v-if="propOrderUpdate != null || propOrderDetailUpdate != null"
            >
                <v-btn
                    text
                    class="deep-orange--text"
                    block
                    large
                    @click="clickSave()"
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
                    บันทึก ({{ sum_price | formatNumber }}฿)
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
    props: [
        "propGoods",
        "propOrder",
        "propOrderUpdate",
        "propOrderDetail",
        "propOrderDetailUpdate",
    ],
    data() {
        return {
            count: 1,
            price: 0,
        };
    },
    methods: {
        async clickSave() {
            let payload = {
                count: this.count,
                price: this.price,
                sum_price: this.sum_price,
            };

            let dispatch = "";

            if (this.propOrder) {
                payload.order_id = this.propOrder.id;
                dispatch = "orderPos/store";
            }

            if (this.propOrderUpdate) {
                payload.id = this.propOrderUpdate.id;
                dispatch = "orderPos/update";
            }

            if (this.propOrderDetail) {
                payload.order_detail_id = this.propOrderDetail.id;
                dispatch = "orderDetailPos/store";
            }

            if (this.propOrderDetailUpdate) {
                payload.id = this.propOrderDetailUpdate.id;
                dispatch = "orderDetailPos/update";
            }

            if (dispatch == "") {
                return;
            }

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
            if (this.count <= 1) {
                return;
            }
            this.count--;
        },
        clickUp() {
            this.count++;
        },
    },
    mounted() {
        this.price = this.propGoods.price;
    },
    computed: {
        sum_price() {
            return this.price * this.count;
        },
    },
};
</script>

<style></style>
