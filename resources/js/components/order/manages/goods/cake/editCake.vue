<template>
    <div v-if="propOrderDetail != null">
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <!-- <v-btn elevation="0" class="white" v-on="on" :block="propBlock">
                    <v-icon left>edit</v-icon>
                    <div>แก้ไขสินค้า</div>
                </v-btn> -->
                <v-list-item v-on="on">
                    <v-list-item-icon>
                        <v-icon>edit</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="py-2">แก้ไขสินค้า</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
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
                        :propAPrice="propOrderDetail.a_price"
                    ></cardAPrice>
                    <v-form lazy-validation ref="form">
                        <v-text-field
                            :label="msg.text.message"
                            outlined
                            hide-details
                            class="mb-3"
                            v-model="propOrderDetail.message"
                            :rules="rules.message"
                        ></v-text-field>
                        <v-textarea
                            :label="msg.text.detail"
                            outlined
                            hide-details
                            class="mb-3"
                            v-model="propOrderDetail.detail"
                            :rules="rules.detail"
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <selectCake
                        :propCheckProduct="propOrderDetail.a_price"
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
    props: ["propOrderDetail", "propBlock"],
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
            this.propOrderDetail.a_price = v;
        },
        // start() {
        //     this.old_detail_temp = this.propOrderDetail;
        //     this.detail_temp = this.propOrderDetail;
        // },
        async save() {
            if (
                !this.$refs.form.validate() ||
                this.propOrderDetail.a_price == {}
            ) {
                this.$toast.warning("โปรดกรอกข้อมูลให้ครบถ้วน");
                return;
            }

            await this.orderDetailUpdate();
            await this.autoUpdateAddOns();

            this.$toast.success("แก้ไขเรียบร้อย");
            this.dialog = false;
        },
        async orderDetailUpdate() {
            let loader = this.$loading.show();
            const payload = this.propOrderDetail;
            await this.$store.dispatch("orderIndex/orderDetailUpdate", payload);
            loader.hide();
        },
        async autoUpdateAddOns() {
            let loader = this.$loading.show();
            const payload = {
                order_detail_id: this.propOrderDetail.id,
                order_id: this.propOrderDetail.order_id,
                m4: this.propOrderDetail.a_price.m4,
                add_ons: this.propOrderDetail.add_ons,
            };

            await this.$store.dispatch("orderIndex/autoUpdateAddOns", payload);
            loader.hide();
        },
        async close() {
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.propOrderDetail.order_id,
            });
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
