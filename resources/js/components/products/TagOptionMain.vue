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

                    <v-select
                        outlined
                        :items="subs1"
                        item-text="name"
                        item-value="id"
                        label="ตัวเลือกหลัก (ย่อย)"
                        v-model="form.subs1"
                        :rules="Rules.subs1"
                    ></v-select>

                    <div v-if="op1 && form.subs1">
                        <v-divider class="mt-0"></v-divider>
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
                        <v-combobox
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
                        ></v-combobox>
                    </div>
                </v-card-text>
            </v-card>
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
            op1: null,
            op2: null,
            subs1: [],
            subs2: [],
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
                this.$toast.warning("ตัวเลือกหลัก ห้ามซ้ำกัน");
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
            if (this.op2 == this.op1) {
                this.$toast.warning("ตัวเลือกหลัก ห้ามซ้ำกัน");
                this.op2 = null;
                this.form.subs2 = null;
                return;
            }
            const res = await this.$store.dispatch(
                "productCategory/getSubByID",
                val
            );
            this.subs2 = res.data;
        }
    }
};
</script>
