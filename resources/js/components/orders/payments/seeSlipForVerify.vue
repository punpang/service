<template>
    <div>
        <v-dialog v-model="dialog" persistent width="850">
            <template v-slot:activator="{ on }">
                <v-btn color="primary" block v-on="on" :disabled="slip.slip_verify_id != 1">
                    ตรวจสอบสลิป
                    <v-icon right>info</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ตรวจสอบสลิป
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">
                        close</v-icon
                    >
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="5">
                            <imageFullPath :path="slip.path"></imageFullPath>
                            <v-divider></v-divider>
                            <v-btn
                                rounded
                                v-for="ref in slip.google_ocr"
                                color="orange"
                                :key="ref.id"
                                class="mr-1 mb-1"
                                @click="clickRef(ref.ocr_text, ref.type)"
                            >
                                {{ ref.ocr_text }}
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="7">
                            <v-row>
                                <v-col cols="5" md="6">วัน-เวลาแจ้งชำระ</v-col>
                                <v-col cols="7" md="6" class="text-right">{{
                                    slip.created_at
                                }}</v-col>
                            </v-row>
                            <CostSub
                                :sum="this.$store.getters['order/getByID'].sum"
                            ></CostSub>

                            <formPayment :sum="this.$store.getters['order/getByID'].sum" :formData="form" @emitExit="emitExit"></formPayment>                            
                            
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import imageFullPath from "@/js/components/google/drive/imageFullPath";
import CostSub from "@/js/components/orders/details/CostSub";
import overlay from "@/js/layouts/overlay";
import formPayment from "@/js/components/orders/payments/_form_payment";

export default {
    props: ["slip"],
    components: {
        imageFullPath,
        CostSub,
        overlay,
        formPayment
    },
    data() {
        return {
            dialog: false,
            form: {
                order_id: this.$store.getters["order/getByID"].data.id,
                order_payment_method_id: 2,
                amount: "",
                slip_id: this.slip.id,
                slip_ref:"",
                status: 1,
                alert: true,
            }
        };
    },
    methods: {
        emitExit(){
            this.dialog = false;
        },
        clickRef(o, t) {
            console.log(o, t);
            if (t == "ref") {
                this.form.slip_ref = o;
            } else if (t == "money") {
                this.form.amount = o;
            }
        },
        async clickCheckRef() {
            if (this.$refs.form.validate()) {
                await this.$store.dispatch("payment/checkRef", this.form);
            }
        }
    }
};
</script>

<style></style>
