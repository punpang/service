<template>
    <div>
        <v-dialog
            persistent
            width="350"
            v-model="dialog"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-icon>
                        <v-icon>local_atm</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="py-2"
                            >บริการล้อม/ลูกบอล/ซ่อนเงิน</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    บริการล้อม/ลูกบอล/ซ่อนเงิน
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-select
                        class="py-1"
                        :items="options"
                        outlined
                        hide-details
                        label="บริการ"
                        v-model="option"
                        item-value="id"
                        @change="changeOption()"
                    ></v-select>
                    <p
                        class="my-1 red--text text-caption font-weight-black"
                        v-if="option"
                    >
                        หมายเหตุ : {{ cash.remark }}
                    </p>

                    <div v-if="option">
                        <v-divider></v-divider>
                        <v-text-field
                            label="แบงค์ 20 บาท"
                            outlined
                            hide-details
                            suffix="แบงค์"
                            class="mb-3"
                            v-model="cash.thb20"
                            @click="cash.thb20 = ''"
                            type="number"
                            pattern="\d*"
                            @change="changeCash(20)"
                            dense
                        ></v-text-field>

                        <v-text-field
                            dense
                            label="แบงค์ 50 บาท"
                            outlined
                            hide-details
                            suffix="แบงค์"
                            class="mb-3"
                            v-model="cash.thb50"
                            @click="cash.thb50 = ''"
                            type="number"
                            pattern="\d*"
                            @change="changeCash(50)"
                        ></v-text-field>

                        <v-text-field
                            dense
                            label="แบงค์ 100 บาท"
                            outlined
                            hide-details
                            suffix="แบงค์"
                            class="mb-3"
                            v-model="cash.thb100"
                            @click="cash.thb100 = ''"
                            type="number"
                            pattern="\d*"
                            @change="changeCash(100)"
                        ></v-text-field>

                        <v-text-field
                            dense
                            label="แบงค์ 500 บาท"
                            outlined
                            hide-details
                            suffix="แบงค์"
                            class="mb-3"
                            v-model="cash.thb500"
                            @click="cash.thb500 = ''"
                            type="number"
                            pattern="\d*"
                            @change="changeCash(500)"
                        ></v-text-field>

                        <v-text-field
                            dense
                            label="แบงค์ 1,000 บาท"
                            outlined
                            hide-details
                            suffix="แบงค์"
                            class="mb-3"
                            v-model="cash.thb1000"
                            @click="cash.thb1000 = ''"
                            type="number"
                            pattern="\d*"
                            @change="changeCash(1000)"
                        ></v-text-field>
                        <v-divider class="mb-0"></v-divider>
                        <v-simple-table>
                            <tbody>
                                <tr>
                                    <td>จำนวนแบงค์</td>
                                    <td class="text-right">
                                        {{ cashSum > 0 ? cashSum : "" }}
                                        แบงค์
                                    </td>
                                </tr>
                                <tr>
                                    <td>จำนวนเงิน</td>
                                    <td class="text-right">
                                        {{ thbSum | formatNumber }} บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td>ค่าบริการ</td>
                                    <td class="text-right">
                                        {{ cash.fee | formatNumber }}
                                        บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td>รวม</td>
                                    <td class="text-right">
                                        {{ cashTotal | formatNumber }}
                                        บาท
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn class="error" @click="exit()">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="success"
                        @click="clickSave()"
                        :disabled="cashSum <= 0 || thbSum <= 0"
                    >
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    props: [],
    components: {},
    data() {
        return {
            dialog: false,
            option: "",
            options: [
                {
                    id: 1,
                    text: "ซ่อนเงิน",
                    fee: 100.0,
                    remark: "สูงสุด 30 แบงค์",
                },
                {
                    id: 2,
                    text: "ล้อมเงิน",
                    fee: 100.0,
                    remark: "1:35,2:40,3:45 *ปอนด์:แบงค์*",
                },
                {
                    id: 3,
                    text: "ลูกบอลใส่เงิน",
                    fee: 100.0,
                    remark: "สูงสุด 10 แบงค์",
                },
            ],
            cash: {
                option_id: "",
                text: "",
                fee: "",
                remark: "",
                thb20: "0",
                thb50: "0",
                thb100: "0",
                thb500: "0",
                thb1000: "0",
            },
            // multiplier: {
            //     thb20: 20,
            //     thb50: 50,
            //     thb100: 100,
            //     thb500: 500,
            //     thb1000: 1000,
            // },
            cashTypes: [20, 50, 100, 500, 1000],
        };
    },
    methods: {
        async clickSave() {
            if (this.cashSum <= 0 || this.thbSum <= 0) {
                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                    position: "bottom",
                });
                return;
            }
        },
        isInteger(v) {
            if (v == "") {
                return 0;
            }

            if (!Number.isInteger(Number(v))) {
                return parseInt(v);
            }

            if (Number(v) <= -0) {
                return parseInt(v) * -1;
            }

            return v;
        },
        changeCash(v) {
            this.cash[`thb${v}`] = this.isInteger(this.cash[`thb${v}`]);
        },

        changeOption() {
            const e = this.options.find((e) => {
                return e.id == this.option;
            });
            this.cash.option_id = e.id;
            this.cash.text = e.text;
            this.cash.remark = e.remark;
            this.cash.fee = e.fee;
        },
        exit() {
            this.dialog = false;
            this.option = "";
            this.cash = {
                option_id: "",
                text: "",
                fee: "",
                remark: "",
                thb20: "0",
                thb50: "0",
                thb100: "0",
                thb500: "0",
                thb1000: "0",
            };
        },
    },
    computed: {
        cashSum() {
            //รวมจำนวนแบงค์
            let sum = 0;
            for (let i = 0; i < this.cashTypes.length; i++) {
                sum += parseInt(this.cash[`thb${this.cashTypes[i]}`]);
            }
            return sum;
        },
        thbSum() {
            // รวมจำนวนเงิน
            let sum = 0;
            for (let i = 0; i < this.cashTypes.length; i++) {
                sum += parseInt(
                    this.cash[`thb${this.cashTypes[i]}`] * this.cashTypes[i]
                );
            }
            return sum;
        },

        cashTotal() {
            //รวมจำนวนเงิน + ค่าบริการ
            return this.thbSum + this.cash.fee;
        },
    },
};
</script>
