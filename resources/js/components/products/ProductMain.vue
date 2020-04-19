<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            fullscreen
            transition="dialog-bottom-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" color="info">
                    กลุ่มสินค้าย่อย
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    ><v-icon left color="success" @click="reload"
                        >refresh</v-icon
                    >จัดการกลุ่มสินค้าย่อย
                    <v-spacer></v-spacer>
                    <v-icon text color="error" @click="dialog = false"
                        >close</v-icon
                    >
                </v-card-title>
                <v-card-text>
                    <addProductCategorySub
                        @click="getUseOnly"
                    ></addProductCategorySub>
                    <getProductCategorySub></getProductCategorySub>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar.status" :color="snackbar.color" right>{{
            snackbar.text
        }}</v-snackbar>
    </div>
</template>

<script>
import addProductCategorySub from "@/js/components/products/addProductCategorySub";
import getProductCategorySub from "@/js/components/products/getProductCategorySub";

export default {
    components: {
        addProductCategorySub,
        getProductCategorySub
    },
    data() {
        return {
            snackbar: {
                status: false
            },
            dialog: false
        };
    },
    methods: {
        async reload() {
            this.$store.commit("productCategorySub/get", []);
            this.snackbar = {
                status: true,
                text: "กำลังโหลดข้อมูล...",
                color: "warning"
            };
            await this.$store.dispatch("productCategorySub/get");
            this.snackbar = {
                status: true,
                text: "โหลดข้อมูลเสร็จสิ้น",
                color: "success"
            };
        },
        getUseOnly() {
            this.$store.dispatch["productCategory/getUseOnly"];
        }
    }
};
</script>

<style></style>
