<template>
    <div>
        <v-dialog persistent width="600" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn elevation="0" class="white" v-on="on" @click="start()">
                    <v-icon left>playlist_add</v-icon>
                    <div class="d-none d-sm-flex">ตัวเลือกเพิ่มเติม</div>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    ตัวเลือกเพิ่มเติม
                    <v-spacer></v-spacer>
                    <v-btn icon from x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="py-2 text-right">
                    {{ add_ons }}
                    <!-- <cardTableAddOns
                        :propAddOns="add_ons"
                        :propAm4="propOrderDetail.a_price.m4"
                        @emitRemoveAddOn="emitRemoveAddOn"
                    ></cardTableAddOns> -->
                    <selectAddOn
                        class="mb-2"
                        :propAm4="propOrderDetail.a_price.m4"
                        @emitPushAddOn="emitPushAddOn"
                        :propAddOns="propOrderDetail.add_ons"
                    ></selectAddOn>
                </v-card-text>
                <v-card-actions>
                    <div class="text-h6 font-weight-bold">
                        รวม {{ sumAddOn }} บาท
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn color="error" @click="exit()">
                        <v-icon left>exit_to_app</v-icon> ออก
                    </v-btn>
                    <v-btn color="success" @click="save()">
                        <v-icon left>save</v-icon> บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import selectAddOn from "@/js/components/order/product/select/selectAddOn";
import cardTableAddOns from "@/js/components/order/product/select/cardTableAddOns";

export default {
    props: ["propOrderDetail"],
    data() {
        return {
            dialog: false,
            add_ons: [],
            // sumAddOn: 0,
        };
    },
    components: {
        selectAddOn,
        cardTableAddOns,
    },
    methods: {
        start() {
            if (this.propOrderDetail.add_ons == null) {
                this.propOrderDetail.add_ons = this.add_ons;
            } else {
                this.add_ons = this.propOrderDetail.add_ons;
            }
        },
        emitPushAddOn(v) {
            this.add_ons = v;
        },
        emitRemoveAddOn(v) {
            this.add_ons.splice(v, 1);
        },
        async save() {
            // this.propOrderDetail.add_ons = this.add_ons;
            // console.log("🚀 ~ file: cardManageAddOn.vue ~ line 82 ~ save ~ this.propOrderDetail.add_ons", this.propOrderDetail.add_ons)

            // return;
            let loader = this.$loading.show();
            this.propOrderDetail.sumAddOn = this.sumAddOn;
            this.propOrderDetail.add_ons = this.add_ons;
            const payload = this.propOrderDetail;

            await this.$store.dispatch("orderIndex/createAddOns", payload);
            loader.hide();
            this.dialog = false;
        },
        async exit() {
            let loader = this.$loading.show();
            const payload = {
                orderID: this.propOrderDetail.order_id,
            };
            await this.$store.dispatch("orderIndex/getOrderByID", payload);
            loader.hide();
            this.dialog = false;
        },
    },
    computed: {
        sumAddOn() {
            return this.add_ons.reduce((sum, { price }) => {
                return parseInt(sum + price);
            }, 0);
        },
    },
};
</script>
