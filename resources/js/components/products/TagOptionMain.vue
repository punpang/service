<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="400">
            <template v-slot:activator="{ on }">
                <v-btn fab x-small v-on="on" color="error" @click="start()">
                    <v-icon>edit</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="pb-0">
                    <h3>ชื่อสินค้า : {{ data.name }}</h3>
                    <v-spacer></v-spacer>
                    <v-btn fab x-small class="red--text" @click="close">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-divider></v-divider>

                <v-form ref="formOP12" lazy-validation>
                    <v-card-text>
                        <v-autocomplete
                            v-model="op1"
                            :items="items1"
                            item-text="name"
                            item-value="id"
                            label="ตัวเลือกหลัก"
                            outlined
                            :rules="Rules.op1"
                            @change="changeOp1"
                        >
                        </v-autocomplete>

                        <v-select
                            outlined
                            :items="subs1"
                            item-text="name"
                            item-value="id"
                            label="ตัวเลือกหลัก (ย่อย)"
                            v-model="form.subs1"
                            :rules="Rules.subs1"
                            @change="formSubs1"
                        ></v-select>

                        <div v-if="op1 && form.subs1">
                            <v-divider class="mt-0"></v-divider>
                            <h4 class="mb-4">เชื่อมต่อกับ</h4>
                            <v-autocomplete
                                v-model="op2"
                                :items="items2"
                                item-text="name"
                                item-value="id"
                                label="ตัวเลือกหลัก"
                                outlined
                                @change="changeOp2"
                                :rules="Rules.op2"
                            >
                            </v-autocomplete>

                            <v-select
                                multiple
                                outlined
                                small-chips
                                item-value="id"
                                item-text="name"
                                label="ตัวเลือกหลัก (ย่อย)"
                                v-if="op2 && op1 != op2"
                                v-model="form.subs2"
                                :items="subs2"
                                :rules="Rules.subs2"
                            ></v-select>
                        </div>

                        <v-btn color="success" @click="SaveOP12">
                            <v-icon left>save</v-icon>
                            ยืนยัน OP
                        </v-btn>
                        <v-btn color="success">
                            <v-icon left>save</v-icon>
                            ยืนยัน PO
                        </v-btn>
                    </v-card-text>
                </v-form>
            </v-card>
            <!--
            <v-stepper >
                <v-stepper-header>
                    <v-stepper-step step="1" :complete="complete > 1">
                        รายการสั่งซื้อสำเร็จ
                        <small v-if="complete > 1" class="mt-1">22/05/64 11.23 น.</small>
                    </v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="2" :complete="complete > 2">
                        รอชำระเงิน
                        <small v-if="complete > 2" class="mt-1">22/05/64 11.24 น.</small>
                    </v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="3" :complete="complete > 3">
                        ชำระเงินสำเร็จ
                        <small v-if="complete > 3" class="mt-1">22/05/64 12.10 น.</small>
                    </v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="4" :complete="complete > 4">
                        เตรียมสินค้าเรียบร้อย
                        <small v-if="complete > 4" class="mt-1">22/05/64 17.36 น.</small>
                    </v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="5" :complete="complete > 5">
                        รับสินค้าแล้ว
                        <small v-if="complete > 5" class="mt-1">22/05/64 18.14 น.</small>
                    </v-stepper-step>
                </v-stepper-header>
            </v-stepper>
            <v-btn @click="count" color="success">บวก</v-btn>
            -->

            {{ op2 }}
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            dialog: false,
            items1: [],
            items2: [],
            op1: null,
            op2: null,
            subs1: [],
            subs2: [],
            complete: 1,
            form: {
                product_id: null,
                subs1: null,
                op1: null,
                subs2: null,
                product_category_id: null,
                status: null
            },
            Rules: {
                op1: [v => !!v || "ห้ามเว้นว่าง"],
                op2: [v => !!v || "ห้ามเว้นว่าง"],
                subs1: [v => !!v || "ห้ามเว้นว่าง"],
                subs2: [v => !!v || "ห้ามเว้นว่าง"]
            }
        };
    },
    methods: {
        count() {
            this.complete += 1;
        },
        async start() {
            const resProduct = await this.$store.dispatch(
                "optionMain/productCheck",
                this.data.id
            );
            const res = await this.$store.dispatch(
                "productCategory/getUseOnly"
            );

            if (resProduct.data == false) {
                this.items1 = [{ id: this.data.id, name: this.data.name }];
                this.op1 = this.data.id;
                this.subs1 = [{ id: this.data.id, name: this.data.name }];
                this.form.subs1 = this.data.id;
            } else {
                this.items1 = res.data;
            }
            this.items2 = res.data;
            this.form.product_id = this.data.id;
        },
        close() {
            this.dialog = false;
            this.form = {
                product_id: null,
                op1: null,
                op2: null
            };
            this.op1 = null;
            this.op2 = null;
            this.subs1 = [];
            this.subs2 = [];
        },
        async SaveOP12() {
            if (this.$refs.formOP12.validate()) {
                const res = await this.$store.dispatch(
                    "optionMain/store",
                    this.form
                );

                console.log(res);

                if (res.status === 200) {
                    this.$toast.success("ทำรายการสำเร็จ");
                }
            }
        },
        async changeOp1() {
            if (this.op2 == this.op1) {
                this.op1 = null;
                this.form.subs1 = null;
                this.op2 = null;
                this.form.subs2 = null;
                return;
            }

            const res = await this.$store.dispatch(
                "productCategory/getSubByID",
                this.op1
            );
            this.subs1 = res.data;

            this.form.subs1 = null;
        },
        async formSubs1() {
            const dataCheck = {
                subs1: this.form.subs1,
                product_id: this.data.id
            };
            const resCheck = await this.$store.dispatch(
                "optionMain/check",
                dataCheck
            );

            if (resCheck.data.status == false) {
                this.form.subs1 = null;
                this.$toast.error("โปรดเลือกใหม่");
                return;
            }

            this.form.subs2 = [];

            for (let i = 0; i < resCheck.data.data.sub.length; i++) {
                this.form.subs2[i] = resCheck.data.data.sub[i].op2;
            }
            this.op2 = resCheck.data.data.product_category_id;
            this.form.op1 = resCheck.data.data.id;
            this.changeOp2();
        },
        async changeOp2() {
            if (this.op2 == this.op1) {
                this.$toast.warning("ตัวเลือกหลัก ห้ามซ้ำกัน");
                this.op2 = null;
                this.form.subs2 = null;
                return;
            }

            this.form.product_category_id = this.op2;

            const res = await this.$store.dispatch(
                "productCategory/getSubByID",
                this.op2
            );
            this.subs2 = res.data;
        }
    },
    watch: {}
};
</script>
