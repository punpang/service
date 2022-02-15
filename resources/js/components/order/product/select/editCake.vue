<template>
    <div v-if="propDetailTemp != null">
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn elevation="0" class="white" v-on="on">
                    <v-icon left>edit</v-icon>
                    แก้ไขสินค้า</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    แก้ไขสินค้า
                    <v-spacer></v-spacer>
                    <v-btn fab x-small icon color="error" @click="close()">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <cardAPrice
                        :propAPrice="propDetailTemp.temp.a_price"
                    ></cardAPrice>
                    <v-form lazy-validation ref="form">
                        <v-text-field
                            :label="msg.text.message"
                            outlined
                            hide-details
                            class="mb-3"
                            v-model="propDetailTemp.temp.message"
                            :rules="rules.message"
                        ></v-text-field>
                        <v-textarea
                            :label="msg.text.detail"
                            outlined
                            hide-details
                            class="mb-3"
                            v-model="propDetailTemp.temp.detail"
                            :rules="rules.detail"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <selectCake
                        :propCheckProduct="propDetailTemp.temp.a_price"
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
// import cardMessage from "@/js/components/order/product/select/cardMessage";
// import cardDetail from "@/js/components/order/product/select/cardDetail";
import cardAPrice from "@/js/components/order/product/select/cardAPirce";

import { mapGetters } from "vuex";
export default {
    props: ["propDetailTemp"],
    components: {
        selectCake,
        // cardMessage,
        // cardDetail,
        cardAPrice,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitAPrice(v) {
            this.propDetailTemp.temp.a_price = v;
        },
        // start() {
        //     this.old_detail_temp = this.propDetailTemp;
        //     this.detail_temp = this.propDetailTemp;
        // },
        async save() {
            if (
                !this.$refs.form.validate() ||
                this.propDetailTemp.temp.a_price == {}
            ) {
                this.$toast.warning("โปรดกรอกข้อมูลให้ครบถ้วน");
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                order_detail_temp: this.propDetailTemp,
            };
            await this.$store.dispatch("orderDetailTemp/update", payload);
            loader.hide();
            this.$toast.success("แก้ไขเรียบร้อย");
            this.close();
        },
        async close() {
            let loader = this.$loading.show();
            const payload = {
                order_temp: { id: this.propDetailTemp.order_temp_id },
            };
            await this.$store.dispatch("orderDetailTemp/fetch", payload);
            loader.hide();
            this.dialog = false;
        },
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
        }),
    },
};
</script>

<style></style>
