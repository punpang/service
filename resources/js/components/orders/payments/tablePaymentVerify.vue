<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
            <template v-slot:activator="{ on }">
                <v-btn color="primary" v-on="on">
                    ตรวจสอบสลิป
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ตรวจสอบสลิป
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-divider class="ma-0"></v-divider>
                <v-card-text>
                    <v-data-table
                        :items="slips"
                        :headers="headers"
                        hide-default-footer
                        :items-per-page="100"
                    >
                        <template v-slot:item.slip_verify="{ item }">
                            <v-btn :color="item.slip_verify.style" block>
                                {{ item.slip_verify.text }}
                            </v-btn>
                        </template>

                        <template v-slot:item.action="{ item }">
                            <seeSlipForVerify :slip="item"></seeSlipForVerify>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import seeSlipForVerify from "@/js/components/orders/payments/seeSlipForVerify";
export default {
    props: ["slips"],
    components:{
        seeSlipForVerify
    },
    data() {
        return {
            dialog: false,
            headers: [
                { text: "วัน-เวลาแจ้งชำระเงิน", value: "created_at" },
                { text: "สถานะ", value: "slip_verify", align: "center" ,sortable: false,},
                { text: "การจัดการ", value: "action", align: "end" ,sortable: false,}
            ]
        };
    }
};
</script>

<style></style>
