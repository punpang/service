<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="info white--text" @click="start()">
                    <v-icon left> {{ msg.icon.goods }} </v-icon
                    >{{ msg.text.goods }}
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <h3>
                        <v-icon left>
                            {{ msg.icon.goods }}
                        </v-icon>
                        {{ msg.text.goods }}
                    </h3>
                    <v-spacer></v-spacer>
                    <v-btn fab x-small icon color="error" @click="close()">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-form lazy-validation ref="form">
                        <v-select
                            outlined
                            :items="fop1"
                            item-text="m1"
                            item-value="id"
                            :label="msg.text.op1"
                            v-model="op1"
                            :rules="rules.op"
                            hide-details
                            class="mb-3"
                            @change="fetchProduct()"
                        ></v-select>
                        <v-select
                            :items="fop2"
                            item-text="m2"
                            item-value="id"
                            outlined
                            :label="msg.text.op2"
                            v-model="op2"
                            :rules="rules.op"
                            hide-details
                            class="mb-3"
                            @change="fetchProduct()"
                        ></v-select>
                        <v-select
                            :items="fop3"
                            item-text="m3"
                            item-value="id"
                            outlined
                            :label="msg.text.op3"
                            v-model="op3"
                            :rules="rules.op"
                            hide-details
                            class="mb-3"
                            @change="fetchProduct()"
                        ></v-select>
                        <v-select
                            :items="fop4"
                            item-text="m4"
                            item-value="id"
                            outlined
                            :label="msg.text.op4"
                            v-model="op4"
                            :rules="rules.op"
                            hide-details
                            class="mb-3"
                            @change="fetchProduct()"
                        ></v-select>
                    </v-form>

                    <v-simple-table
                        class="mb-0"
                        v-if="dataSelectedSuccess && product"
                    >
                        <tbody>
                            <tr>
                                <td>
                                    <h4 class="mb-0">{{ msg.text.price }}</h4>
                                </td>
                                <td class="text-right">
                                    <h4 class="mb-0">
                                        <strong
                                            >฿
                                            {{
                                                product.price | formatNumber
                                            }}</strong
                                        >
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </v-simple-table>
                    <v-alert
                        type="info"
                        class="mb-0"
                        v-if="dataSelectedSuccess && !product"
                        >โปรดเพิ่มสินค้า</v-alert
                    >
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <addPrice
                        v-if="!product && dataSelectedSuccess"
                        :propOptions="dataMerge"
                        :propDataSelectedSuccess="dataSelectedSuccess"
                    ></addPrice>

                    <!-- // -->
                    <v-btn
                        class="success mr-2"
                        v-if="product && dataSelectedSuccess"
                        @click="clickSelect()"
                    >
                        <v-icon left>
                            {{ msg.icon.select }}
                        </v-icon>
                        {{ msg.text.select }}
                    </v-btn>
                    <!-- // -->
                    <editPrice
                        v-if="dataSelectedSuccess && product"
                        :propProduct="product"
                    ></editPrice>
                    <!-- // -->
                    <v-btn class="error mr-2" @click="reset()">
                        <v-icon left>
                            {{ msg.icon.clear }}
                        </v-icon>
                        {{ msg.text.clear }}
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

import { mapGetters } from "vuex";
import editPrice from "@/js/components/order/product/select/editPrice";
import addPrice from "@/js/components/order/product/select/addPrice";

export default {
    props: ["propCheckProduct"],
    components: { editPrice, addPrice },
    data() {
        return {
            dialog: false,
            op1: "",
            op2: "",
            op3: "",
            op4: "",
        };
    },
    methods: {
        async fetchProduct() {
            if (this.$refs.form.validate()) {
                const data = this.dataMerge;
                let loader = this.$loading.show();
                await this.$store.dispatch(
                    "orderProductCake/fetchProduct",
                    data
                );
                loader.hide();
            }
        },
        start() {
            // return;
            if (this.propCheckProduct.id) {
                this.op1 = this.propCheckProduct.m1;
                this.op2 = this.propCheckProduct.m2;
                this.op3 = this.propCheckProduct.m3;
                this.op4 = this.propCheckProduct.m4;
            } else {
                this.reset();
            }
        },
        clickSelect() {
            // this.$store.commit("orderProductCake/product", this.product);
            this.$emit("emitAPrice", this.product);
            this.dialog = false;
        },
        reset() {
            this.op1 = "";
            this.op2 = "";
            this.op3 = "";
            this.op4 = "";
        },
        close() {
            this.dialog = false;
        },
    },
    async mounted() {
        let loader = this.$loading.show();

        const resOption = await this.$store.dispatch(
            "orderProductCake/fetchOption"
        );

        if (resOption != 200) {
            this.$toast.error("โหลด OPTION ไม่สำเร็จ");
        }

        loader.hide();
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
            product: "orderProductCake/fetchProduct",
            fop1: "orderProductCake/op1",
            fop2: "orderProductCake/op2",
            fop3: "orderProductCake/op3",
            fop4: "orderProductCake/op4",
        }),
        dataSelectedSuccess() {
            if (!this.op1 || !this.op2 || !this.op3 || !this.op4) {
                return false;
            }
            return true;
        },

        dataMerge() {
            const data = {
                op1: this.op1,
                op2: this.op2,
                op3: this.op3,
                op4: this.op4,
            };

            return data;
        },
    },
};
</script>

<style></style>
