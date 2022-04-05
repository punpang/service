<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small dark class="warning" v-on="on">
                    <v-icon>edit</v-icon></v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    แก้ไขตัวเลือก
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <fromProductAddOn :propAddOn="propAddOn"></fromProductAddOn>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import fromProductAddOn from "@/js/components/order/manages/goods/cake/addOn/productAddOn/fromProductAddOn";

export default {
    props: ["propAddOn"],
    data() {
        return {
            dialog: false,
        };
    },
    components: {
        fromProductAddOn,
    },
    methods: {
        exit() {
            this.dialog = false;
        },
    },
};
</script>
