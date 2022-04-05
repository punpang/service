<template>
    <div>
        <v-dialog width="500" scrollable persistent v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn class="info" v-on="on"> ตัวเลือก </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    ตัวเลือก
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="py-2">
                    <selectAddOn
                        class="mb-2"
                        :propAm4="propAm4"
                        :propAddOns="propOrderDetail.add_ons"
                        :propOrderDetail="propOrderDetail"
                    ></selectAddOn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import selectAddOn from "@/js/components/order/manages/goods/cake/addOn/selectAddOn";

export default {
    props: ["propAm4", "propAddOns", "propOrderDetail"],
    data() {
        return {
            dialog: false,
        };
    },
    components: {
        selectAddOn,
    },
    methods: {
        exit() {
            this.dialog = false;
        },
    },
};
</script>
