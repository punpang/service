<template>
    <div>
        <v-dialog v-model="dialog" persistent width="350">
            <template v-slot:activator="{ on }">
                <v-btn color="error" v-on="on" small>
                    <v-icon left>cancel</v-icon>
                    ยกเลิกรายการ
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ยกเลิกการชำระเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6" md="6">คำสั่งซื้อ</v-col>
                        <v-col cols="6" md="6" class="text-right"
                            >#{{ payment.order_id }}</v-col
                        >
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">ช่องทางการชำระเงิน</v-col>
                        <v-col cols="6" md="6" class="text-right"
                            >#{{ payment.payment_method_id }}</v-col
                        >
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">เลขที่ใบเสร็จ</v-col>
                        <v-col cols="6" md="6" class="text-right"
                            >#{{ payment.bill_id }}</v-col
                        >
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">สถานะ</v-col>
                        <v-col cols="6" md="6" class="text-right py-2">
                            <setStautsColorText
                                :status="payment.status"
                            ></setStautsColorText>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6" md="6">วัน-เวลาทำรายการ</v-col>
                        <v-col cols="6" md="6" class="text-right">
                            {{ payment.updated_at }}
                        </v-col>
                    </v-row>
                    <v-alert type="warning"
                        >ต้องการยกเลิกรายการใช่ไหม ?</v-alert
                    >
                    <v-form
                    ref="form"
                    lazy-validation>
                        <v-text-field
                        outlined
                        label="โปรดกรอกคำนวน 'ยกเลิก' ลงในช่อง"
                        :rules="[v => v == 'ยกเลิก']"
                        hide-details
                        class="mb-4"
                    ></v-text-field>
                    </v-form>
                    
                    <v-btn color="error" large @click="clickCancelPayment">
                        <v-icon left>delete</v-icon>
                        ยกเลิกรายการ
                    </v-btn>
                    <v-btn color="primary" large @click="dialog = false">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import setStautsColorText from "@/js/components/orders/payments/setStautsColorText";

export default {
    props: ["payment"],
    components: {
        setStautsColorText
    },
    data() {
        return {
            dialog: false
        };
    },
    methods:{
        clickCancelPayment(){
            if(this.$refs.form.validate()){
                console.log('pass');
                
            }else{
                console.log('dont pass');
                
            }
        }
    }
};
</script>

<style></style>
