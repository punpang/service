<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
            <template v-slot:activator="{ on }">
                <v-btn
                    :color="action.buttonHead.color"
                    class="mr-2 d-none d-sm-flex"
                    v-on="on"
                    @click="start"
                >
                    <v-icon left>{{ action.buttonHead.icon }}</v-icon>
                    {{ action.buttonHead.text }}
                </v-btn>
                <v-btn
                    :color="action.buttonHead.color"
                    class="mr-2 d-flex d-sm-none"
                    fab
                    small
                    @click="start"
                    v-on="on"
                >
                    <v-icon>{{ action.buttonHead.icon }}</v-icon>
                    <!-- ยกเลิก -->
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    {{ main.titleText }}
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <productDetail :detail="detail"></productDetail>
                    <v-alert :type="main.vAlert.type">{{
                        main.vAlert.text
                    }}</v-alert>
                    <v-form ref="form" lazy-validation>
                        <v-text-field
                            class="mb-0"
                            outlined
                            :label="main.labelConfirm"
                            v-model="confirmText"
                            autocomplete="false"
                        
                            :rules="[
                                v => !!v || 'ห้ามเว้นว่าง',
                                v =>
                                    v == main.rules.textComfirm ||
                                    main.rules.textAlert
                            ]"
                        ></v-text-field>
                    </v-form>

                    <v-btn
                        @click="clickSubmit"
                        :class="main.buttonSubmit.submit.color"
                    >
                        <v-icon left>{{
                            main.buttonSubmit.submit.icon
                        }}</v-icon>
                        {{ main.buttonSubmit.submit.text }}</v-btn
                    >
                    <v-btn
                        @click="dialog = false"
                        :class="main.buttonSubmit.cancel.color"
                    >
                        <v-icon left>{{
                            main.buttonSubmit.cancel.icon
                        }}</v-icon>
                        {{ main.buttonSubmit.cancel.text }}</v-btn
                    >
                </v-card-text>
            </v-card>
            <overlay :overlay="overlay"></overlay>
        </v-dialog>
    </div>
</template>

<script>
import productDetail from "@/js/components/orders/details/productDetail";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["detail", "action"],
    components: {
        productDetail,
        overlay
    },
    data() {
        return {
            dialog: false,
            confirmText: "",
            overlay: false,
            response: {},
            main: {
                titleText: "",
                vAlert: {
                    type: "",
                    text: ""
                },
                labelConfirm: "",
                rules: {
                    textComfirm: "",
                    alert: ""
                },
                buttonSubmit: {
                    submit: {
                        text: "",
                        color: "",
                        icon: ""
                    },
                    cancel: {
                        text: "",
                        color: "",
                        icon: ""
                    }
                }
            }
        };
    },
    methods: {
        start() {
            this.confirmText = "";
            if (this.action.method == "delete") {
                this.main = {
                    titleText: "ยกเลิกสินค้า",
                    vAlert: {
                        type: "warning",
                        text: "คุณต้องการยกเลิกสินค้านี้ใช่ไหม ?"
                    },
                    labelConfirm: "โปรดกรอกคำว่า 'ยกเลิก' ลงช่องนี้",
                    rules: {
                        textComfirm: "ยกเลิก",
                        textAlert: "โปรดกรอกคำว่า 'ยกเลิก' เท่านั้น"
                    },
                    buttonSubmit: {
                        submit: {
                            text: "ยกเลิกสินค้า",
                            color: "error",
                            icon: "cancel"
                        },
                        cancel: {
                            text: "ออก",
                            color: "info",
                            icon: "exit_to_app"
                        }
                    }
                };
            } else if (this.action.method == "redelete") {
                this.main = {
                    titleText: "เรียกสินค้า",
                    vAlert: {
                        type: "info",
                        text: "คุณต้องการเรียกคืนสินค้านี้ใช่ไหม ?"
                    },
                    labelConfirm: "โปรดกรอกคำว่า 'เรียกคืน' ลงช่องนี้",
                    rules: {
                        textComfirm: "เรียกคืน",
                        textAlert: "โปรดกรอกคำว่า 'เรียกคืน' เท่านั้น"
                    },
                    buttonSubmit: {
                        submit: {
                            text: "เรียกคืนสินค้า",
                            color: "success",
                            icon: "save"
                        },
                        cancel: {
                            text: "ออก",
                            color: "error",
                            icon: "exit_to_app"
                        }
                    }
                };
            }
        },
        async clickSubmit() {
            if (this.$refs.form.validate()) {
                this.overlay = true;
                const form = {
                    detail_id: this.detail.id,
                    order_id: this.detail.order_id
                };
                if (this.confirmText == "ยกเลิก") {
                    this.response = await this.$store.dispatch(
                        "orderDetail/delete",
                        form
                    );
                } else if (this.confirmText == "เรียกคืน") {
                    this.response = await this.$store.dispatch(
                        "orderDetail/redelete",
                        form
                    );
                }

                await this.$store.dispatch("order/getByID", this.detail.order_id);

                if (this.response.status == 200) {
                    this.$toast.success("ทำรายการสำเร็จ")
                    this.overlay = false;
                    this.dialog = false;
                } else {
                    this.$toast.error("เกิดข้อผิดพลาดบางอย่างขึ้น กรุณาลองอีกครั้งภายหลัง")
                    this.overlay = false;
                }
            } else {
                this.$toast.warning("กรุณากรอกข้อมูลให้ถูกต้อง")
                this.overlay = false;
            }
        }
    }
};
</script>

<style></style>
