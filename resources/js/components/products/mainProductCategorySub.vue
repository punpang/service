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
                    กลุ่มสินค้าย่อย
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    ><v-icon left color="success" @click="reload"
                        >refresh</v-icon
                    >จัดการกลุ่มสินค้าย่อย
                    <v-spacer></v-spacer>
                    <v-icon text color="error" @click="clickExit"
                        >close</v-icon
                    >
                </v-card-title>
                <v-card-text>
                    <addProductCategorySub></addProductCategorySub>
                    <getProductCategorySub></getProductCategorySub>
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
import addProductCategorySub from "@/js/components/products/addProductCategorySub";
import getProductCategorySub from "@/js/components/products/getProductCategorySub";

export default {
    components: {
        addProductCategorySub,
        getProductCategorySub
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
            this.$store.commit("productCategorySub/get", []);
            this.$toast.warning("กำลังโหลดข้อมูล...")
            await this.$store.dispatch("productCategorySub/get");
            await this.$store.dispatch("productCategory/getUseOnly");
            this.$toast.success("โหลดข้อมูลเสร็จสิ้น")
            
            this.overlay = false;
        },
        async clickExit(){         
            await this.$store.dispatch(
                "productCategory/get"
            );
            this.dialog = false
        }
    }
};
</script>

<style></style>
