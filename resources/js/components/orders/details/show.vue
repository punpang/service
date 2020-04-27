<template>
    <div>
        <v-card>
            <v-card-title>
                รายละเอียด
                <v-spacer></v-spacer>
                <v-icon @click="start" color="success">refresh</v-icon>
            </v-card-title>
            <v-divider class="ma-1"></v-divider>
        </v-card>
        <div v-if="count > 0">
            
            <v-card
                v-for="detail in details"
                :key="detail.id"
                class="mt-4"
            >
                <v-card-text class="pa-0">
                    <v-container class="py-0">
                        <productDetail :detail="detail"></productDetail>
                        <buttonForAction :detail="detail"></buttonForAction>

                        <v-col
                            cols="12"
                            md="12"
                            class="pt-0 d-flex d-sm-none"
                            v-if="1 == 2"
                        >
                            <v-btn
                                color="primary"
                                v-if="detail.upload_image_status"
                                class="mr-2"
                                fab
                                small
                            >
                                <v-icon>link</v-icon>
                                <!-- ส่งลิงก์อัปโหลดรูป -->
                            </v-btn>
                            <v-btn color="error" class="mr-2" fab small>
                                <v-icon>cancel</v-icon>
                                <!-- ยกเลิก -->
                            </v-btn>
                        </v-col>
                    </v-container>
                </v-card-text>
            </v-card>
        </div>
        
        <v-alert type="info" v-else>
            ยังไม่มีสินค้า
        </v-alert>

        <div v-if="countNo > 0">

            <v-card
                v-for="detail in detailsNo"
                :key="detail.id"
                class="mt-4"
            >
                <v-card-text class="pa-0">
                    <v-container class="py-0">
                        <productDetail :detail="detail"></productDetail>
                        <buttonForAction :detail="detail"></buttonForAction>

                        <v-col
                            cols="12"
                            md="12"
                            class="pt-0 d-flex d-sm-none"
                            v-if="1 == 2"
                        >
                            <v-btn
                                color="primary"
                                v-if="detail.upload_image_status"
                                class="mr-2"
                                fab
                                small
                            >
                                <v-icon>link</v-icon>
                                <!-- ส่งลิงก์อัปโหลดรูป -->
                            </v-btn>
                            <v-btn color="error" class="mr-2" fab small>
                                <v-icon>cancel</v-icon>
                                <!-- ยกเลิก -->
                            </v-btn>
                        </v-col>
                    </v-container>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
import productDetail from "@/js/components/orders/details/productDetail";
import buttonForAction from "@/js/components/orders/details/buttonForAction";

export default {
    props:[
        'details','count','detailsNo','countNo'
    ],
    components: {
        productDetail,
        buttonForAction
    },
    data() {
        return {};
    },
    methods: {
        start() {
            this.$emit("emitStart");
        }
    }
};
</script>

<style></style>
