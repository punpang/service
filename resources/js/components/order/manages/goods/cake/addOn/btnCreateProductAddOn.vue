<template>
    <div>
        <v-dialog width="500" scrollable persistent v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn class="success" v-on="on">
                    <v-icon left>add</v-icon>
                    สร้าง
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    สร้างตัวเลือก
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <fromProductAddOn></fromProductAddOn>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import fromProductAddOn from "@/js/components/order/manages/goods/cake/addOn/productAddOn/fromProductAddOn";

export default {
    props: [],
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
