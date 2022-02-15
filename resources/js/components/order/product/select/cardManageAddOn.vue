<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn elevation="0" class="white" v-on="on" @click="start()">
                    <v-icon left>playlist_add</v-icon>
                    <div class="d-none d-sm-flex">ตัวเลือกเพิ่มเติม</div>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    ตัวเลือกเพิ่มเติม {{ sumAddOn }}
                    <v-spacer></v-spacer>
                    <v-btn icon from x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-2">
                    <cardTableAddOns
                        :propAddOns="add_ons"
                        :propAm4="propDetailTemp.temp.a_price.m4"
                        @emitRemoveAddOn="emitRemoveAddOn"
                    ></cardTableAddOns>
                    <selectAddOn
                        :propAm4="propDetailTemp.temp.a_price.m4"
                        @emitPushAddOn="emitPushAddOn"
                    ></selectAddOn>
                </v-card-text>
                <v-card-actions>
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
    props: ["propDetailTemp"],
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
            if (this.propDetailTemp.temp.add_ons == null) {
                this.propDetailTemp.temp.add_ons = this.add_ons;
            } else {
                this.add_ons = this.propDetailTemp.temp.add_ons;
            }
        },
        emitPushAddOn(v) {
            this.add_ons.push(v);
        },
        emitRemoveAddOn(v) {
            this.add_ons.splice(v, 1);
        },
        async save() {
            let loader = this.$loading.show();
            this.propDetailTemp.temp.sumAddOn = this.sumAddOn;
            const payload = {
                order_detail_temp: this.propDetailTemp,
            };
            await this.$store.dispatch("orderDetailTemp/update", payload);
            loader.hide();
            this.dialog = false;
        },
        async exit() {
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
        sumAddOn() {
            return this.add_ons.reduce((sum, { price }) => {
                return parseInt(sum + price);
            }, 0);
        },
    },
};
</script>
