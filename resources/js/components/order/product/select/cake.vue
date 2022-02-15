<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <!-- <v-btn v-on="on" class="orange white--text">เพิ่มสินค้า</v-btn> -->
                <v-list-item v-on="on" @click="start()">
                    <v-list-item-title>เพิ่มสินค้า</v-list-item-title>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title>
                    <h3>เพิ่มสินค้า</h3>
                    <v-spacer></v-spacer>
                    <v-btn fab x-small icon color="error" @click="close()">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <cardAPrice :propAPrice="a_price"></cardAPrice>
                    <v-form lazy-validation ref="form">
                        <v-text-field
                            :label="msg.text.message"
                            outlined
                            hide-details
                            class="mb-3"
                            v-model="message"
                            :rules="rules.message"
                        ></v-text-field>
                        <v-textarea
                            :label="msg.text.detail"
                            outlined
                            hide-details
                            class="mb-3"
                            v-model="detail"
                            :rules="rules.detail"
                        ></v-textarea>
                    </v-form>

                    {{ a_price }}
                    {{ message }}
                    {{ detail }}
                </v-card-text>
                <v-card-actions>
                    <selectCake
                        :propCheckProduct="a_price"
                        @emitAPrice="emitAPrice"
                        class="mb-3"
                    ></selectCake>
                    <v-spacer></v-spacer>
                    <v-btn class="error" @click="close()">
                        <v-icon left>
                            {{ msg.icon.clear }}
                        </v-icon>
                        {{ msg.text.clear }}
                    </v-btn>
                    <v-btn class="success" @click="save()">
                        <v-icon left>
                            {{ msg.icon.save }}
                        </v-icon>
                        {{ msg.text.save }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00"); // displaying other groupings/separators is possible, look at the docs
});

import selectCake from "@/js/components/order/product/select/selectCake";
import cardMessage from "@/js/components/order/product/select/cardMessage";
import cardDetail from "@/js/components/order/product/select/cardDetail";
import cardAPrice from "@/js/components/order/product/select/cardAPirce";

import { mapGetters } from "vuex";
export default {
    props: ["propProduct"],
    components: {
        selectCake,
        cardMessage,
        cardDetail,
        cardAPrice,
    },
    data() {
        return {
            dialog: false,
            a_price: {},
            message: "",
            detail: "",
        };
    },
    methods: {
        emitAPrice(v) {
            this.a_price = v;
        },
        // emitProduct(v) {
        //     const product = this.product;
        //     this.product = v;
        //     this.product.message = product.message;
        //     this.product.detail = product.detail;
        // },

        async save() {
            if (!this.$refs.form.validate() || this.a_price == {}) {
                this.$toast.warning("โปรดกรอกข้อมูลให้ครบถ้วน");
                return;
            }

            const payload = {
                product: {
                    a_price: this.a_price,
                    message: this.message,
                    detail: this.detail,
                },
                order_temp: this.temp,
            };
            // console.log(payload);
            return;
            await this.$store.dispatch("orderDetailTemp/create", payload);
            // this.$emit("emitProducts", this.product);
            this.close();
            // this.product = {
            //     message: "",
            //     detail: "",
            // };
        },
        start() {
            // console.log(this.propProduct);
            if (this.propProduct) {
                this.$store.commit(
                    "orderProductCake/setProduct",
                    this.propProduct
                );
            } else {
                this.resetProduct();
            }
        },
        close() {
            this.dialog = false;
        },
        resetProduct() {
            this.$store.commit("orderProductCake/resetProduct");
        },
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
            temp: "orderTemp/temp",
            product: "orderProductCake/product",
        }),
    },
};
</script>

<style></style>
