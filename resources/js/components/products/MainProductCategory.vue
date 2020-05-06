<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            fullscreen
            transition="dialog-bottom-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" color="info" @click="reload">
                    กลุ่มสินค้า
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    ><v-icon left color="success" @click="reload"
                        >refresh</v-icon
                    >จัดการกลุ่มสินค้าใหญ่
                    <v-spacer></v-spacer>
                    <v-icon text color="error" @click="dialog = false"
                        >close</v-icon
                    >
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <addProductCategory class="mr-2"></addProductCategory>
                        <mainProductCategorySub></mainProductCategorySub>
                    </v-row>

                    <getProductCategory></getProductCategory>
                </v-card-text>
            </v-card>
            <v-overlay :value="overlay">
                <v-progress-circular
                    indeterminate
                    :size="this.$store.getters['main/sizeOverlay']"
                ></v-progress-circular>
            </v-overlay>
        </v-dialog>
    </div>
</template>

<script>
import addProductCategory from "@/js/components/products/addProductCategory";
import getProductCategory from "@/js/components/products/getProductCategory";

import mainProductCategorySub from "@/js/components/products/mainProductCategorySub";

export default {
    components: {
        addProductCategory,
        getProductCategory,
        mainProductCategorySub
    },
    data() {
        return {
            overlay: false,
            dialog: false
        };
    },
    methods: {
        async reload() {
            this.overlay = true;
            this.$store.commit("productCategory/get", []);
             this.$toast.warning("กำลังโหลดข้อมูล...")

            await this.$store.dispatch("productCategory/get");
             this.$toast.success("โหลดข้อมูลเสร็จสิ้น")
            this.overlay = false;
        }
    }
};
</script>

<style></style>
