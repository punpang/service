<template>
    <div>
        <v-dialog persistent width="600" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <!-- <v-btn
                    elevation="0"
                    class="white text-left"
                    v-on="on"
                    :block="propBlock"
                >
                    <v-icon left>playlist_add</v-icon>
                    <div>ตัวเลือกเพิ่มเติม</div>
                </v-btn> -->
                <v-list-item v-on="on">
                    <v-list-item-icon>
                        <v-icon>playlist_add</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>ตัวเลือกเพิ่มเติม</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
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
                    <cardTableAddOns
                        :propOrderDetail="propOrderDetail"
                        :propAm4="propOrderDetail.a_price.m4"
                    ></cardTableAddOns>
                </v-card-text>
                <v-card-actions>
                    <!-- <div class="text-h6 font-weight-bold">
                        รวม {{ sumAddOn }} บาท
                    </div> -->
                    <btnSelectAddOn
                        :propAm4="propOrderDetail.a_price.m4"
                        :propOrderDetail="propOrderDetail"
                        class="mr-2"
                    ></btnSelectAddOn>
                    <btnCreateProductAddOn></btnCreateProductAddOn>
                    <v-spacer></v-spacer>
                    <v-btn color="error" @click="exit()">
                        <v-icon left>exit_to_app</v-icon> ออก
                    </v-btn>
                    <!-- <v-btn color="success" @click="save()">
                        <v-icon left>save</v-icon> บันทึก
                    </v-btn> -->
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardTableAddOns from "@/js/components/order/manages/goods/cake/addOn/cardTableAddOns";
import btnSelectAddOn from "@/js/components/order/manages/goods/cake/addOn/btnSelectAddOn";
import btnCreateProductAddOn from "@/js/components/order/manages/goods/cake/addOn/btnCreateProductAddOn";

export default {
    props: ["propOrderDetail", "propBlock"],
    data() {
        return {
            dialog: false,
            add_ons: [],
            // sumAddOn: 0,
        };
    },
    components: {
        btnSelectAddOn,
        cardTableAddOns,
        btnCreateProductAddOn,
    },
    methods: {
        // start() {
        //     if (this.propOrderDetail.add_ons == null) {
        //         this.propOrderDetail.add_ons = this.add_ons;
        //     } else {
        //         this.add_ons = this.propOrderDetail.add_ons;
        //     }
        // },

        // async save() {

        //     let loader = this.$loading.show();
        //     this.propOrderDetail.sumAddOn = this.sumAddOn;
        //     this.propOrderDetail.add_ons = this.add_ons;
        //     const payload = this.propOrderDetail;

        //     await this.$store.dispatch("orderIndex/createAddOns", payload);
        //     loader.hide();
        //     this.dialog = false;
        // },
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
