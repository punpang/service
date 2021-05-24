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
                <v-card-text>
                    <v-autocomplete
                        v-model="op1"
                        :items="items"
                        item-text="name"
                        item-value="id"
                        label="ตัวเลือกหลัก"
                        outlined
                        :rules="Rules.op1"
                    >
                    </v-autocomplete>

                    <h4 class="mb-4">เชื่อมต่อกับ</h4>
                    <v-autocomplete
                        v-model="op2"
                        :items="items"
                        item-text="name"
                        item-value="id"
                        label="ตัวเลือกหลัก"
                        outlined
                        :rules="Rules.op2"
                        :readonly="readonly"
                    >
                    </v-autocomplete>

                    <div>
                        <v-divider class="mt-0"></v-divider>

                        <v-row v-for="item in subs1" :key="item.id">
                            <v-col cols="12">
                                <v-checkbox :label="item.name" v-model="i1" :value="item.id"></v-checkbox>
                            </v-col>
                            <v-col
                            class="ml-10"
                                cols="12"
                                v-for="item2 in subs2"
                                :key="item2.id"
                            >
                                <v-checkbox :label="item2.name" :readonly="!i1" v-model="i2("11")" :value="item2.id"></v-checkbox>
                            </v-col>
                        </v-row>
                    </div>

                    <v-btn color="success">
                        <v-icon left>save</v-icon>
                        ยืนยัน
                    </v-btn>
                </v-card-text>
                {{ i1 }}
                <v-divider></v-divider>
                {{ i2 }}
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
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            dialog: false,
            readonly: false,
            items: [],
            i1:[],
            op1: null,
            op2: null,
            subs1: [],
            subs2: [],
            complete: 1,
            form: {
                product_id: null,
                subs1: null,
                subs2: null
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
            const res = await this.$store.dispatch(
                "productCategory/getUseOnly"
            );
            this.items = res.data;
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
        }
    },
    watch: {
        async op1(val) {
            if (this.op2 == this.op1) {
                this.op1 = null;
                this.form.subs1 = null;
                this.op2 = null;
                this.form.subs2 = null;
                return;
            }
            const res = await this.$store.dispatch(
                "productCategory/getSubByID",
                val
            );
            this.subs1 = res.data;
        },
        async op2(val) {
            const res = await this.$store.dispatch(
                "productCategory/getSubByID",
                val
            );
            this.subs2 = res.data;
        },
        i2(k,v){

        }
    }
};
</script>
