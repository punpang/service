<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
            <template v-slot:activator="{ on }">
                <v-btn color="error" class="mr-2 d-none d-sm-flex" v-on="on">
                    <v-icon left>cancel</v-icon>
                    ยกเลิก
                </v-btn>
                <v-btn
                    color="error"
                    class="mr-2 d-flex d-sm-none"
                    fab
                    small
                    v-on="on"
                >
                    <v-icon>cancel</v-icon>
                    <!-- ยกเลิก -->
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ยกเลิกสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <productDetail :detail="detail"></productDetail>
                    <v-alert type="warning"
                        >คุณต้องการยกเลิกสินค้านี้ใช่ไหม ?</v-alert
                    >
                    <v-text-field
                        class="mb-0"
                        outlined
                        label="โปรดกรอกคำว่า 'ยกเลิก' ลงช่องนี้"
                        v-model="confirmDelete"
                        :rules="[v => !!v || 'ห้ามเว้นว่าง', v => v == 'ยกเลิก' || 'โปรดกรอกคำว่า ยกเลิก เท่านั้น']"
                    ></v-text-field>
                    <v-btn @click="clickDelete" class="error">
                        <v-icon left>cancel</v-icon>
                        ยกเลิก</v-btn
                    >
                    <v-btn @click="dialog = false" class="primary">
                        <v-icon left>exit_to_app</v-icon>
                        ออก</v-btn
                    >
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import productDetail from "@/js/components/orders/details/productDetail";
export default {
    props: ["detail"],
    components: {
        productDetail
    },
    data() {
        return {
            dialog: false,
            confirmDelete: ""
        };
    },
    methods: {
        clickDelete() {
            if (this.confirmDelete == "ยกเลิก") {
                console.log("pass can delete it");
            }
        }
    }
};
</script>

<style></style>
