<template>
    <div>
        <v-dialog
            persistent
            width="800"
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
                            >บริการล้อม/ลูกบอล/ซ่อนเงิน/ดึงเงิน</v-list-item-title
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
                    <v-divider v-if="option"></v-divider>
                    <v-row v-if="option">
                        <v-col cols="12" md="6">
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
                            <v-textarea
                                dense
                                label="หมายเหตุ"
                                outlined
                                hide-details
                                v-model="cash.note"
                            ></v-textarea>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-simple-table>
                                <tbody>
                                    <tr
                                        :class="
                                            cash.max < cashSum
                                                ? 'red white--text'
                                                : ''
                                        "
                                    >
                                        <td>จำนวนแบงค์</td>
                                        <td class="text-right">
                                            {{ cashSum > 0 ? cashSum : 0 }} /
                                            {{ cash.max }}
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

                            <v-btn text color="error" class="my-3" large block>
                                <v-icon left>delete</v-icon>
                                ลบรายการนี้
                            </v-btn>
                            <!-- <v-alert
                                type="error"
                                class="mt-2 mb-1"
                                dense
                                v-if="cash.max < cashSum"
                            >
                                จำนวนแบงค์เกิน {{ cash.max }} แบงค์
                            </v-alert> -->
                        </v-col>
                    </v-row>
                    <!-- <div v-if="option">
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
                        <v-text-field
                            dense
                            label="หมายเหตุ"
                            outlined
                            hide-details
                            v-model="cash.note"
                        ></v-text-field>

                        <v-divider class="mb-0"></v-divider>
                        <v-alert
                            type="error"
                            class="mt-2 mb-1"
                            dense
                            v-if="cash.max < cashSum"
                        >
                            จำนวนแบงค์เกิน {{ cash.max }} แบงค์
                        </v-alert>
                        <v-simple-table>
                            <tbody>
                                <tr>
                                    <td>จำนวนแบงค์</td>
                                    <td class="text-right">
                                        {{ cashSum > 0 ? cashSum : 0 }} /
                                        {{ cash.max }}
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
                    </div> -->
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
                        :disabled="
                            cashSum <= 0 || thbSum <= 0 || cash.max < cashSum
                        "
                    >
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-divider></v-divider>

        <v-col md="8">
            <v-card>
                <v-card-title class="text-h6"> บริการเสริม </v-card-title>
                <v-card-text>
                    <v-card outlined>
                        <v-card-title class="body-1 font-weight-bold"
                            >บริการ : ดึงเงิน
                            <v-spacer></v-spacer>
                            <v-btn icon fab x-small>
                                <v-icon color="warning">edit</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-text class="subtitle-1">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <!-- <ul>
                                        <li>20 บาท x 2 แบงค์</li>
                                        <li>50 บาท x 5 แบงค์</li>
                                        <li>100 บาท x 8 แบงค์</li>
                                        <li>500 บาท x 7 แบงค์</li>
                                        <li>1,000 บาท x 2 แบงค์</li>
                                    </ul> -->
                                    <v-simple-table>
                                        <tbody>
                                            <tr>
                                                <td>20 บาท</td>
                                                <td class="text-right">
                                                    2 แบงค์
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>50 บาท</td>
                                                <td class="text-right">
                                                    2 แบงค์
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>100 บาท</td>
                                                <td class="text-right">
                                                    2 แบงค์
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>500 บาท</td>
                                                <td class="text-right">
                                                    2 แบงค์
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1,000 บาท</td>
                                                <td class="text-right">
                                                    2 แบงค์
                                                </td>
                                            </tr>
                                        </tbody>
                                    </v-simple-table>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-simple-table>
                                        <tbody>
                                            <tr>
                                                <td>จำนวนแบงค์</td>
                                                <td class="text-right">
                                                    24 แบงค์
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>จำนวนเงิน</td>
                                                <td class="text-right">
                                                    12,000 บาท
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>ค่าบริการ</td>
                                                <td class="text-right">
                                                    100 บาท
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>รวม</td>
                                                <td class="text-right">
                                                    12,100 บาท
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>หมายเหตุ</td>
                                                <td class="text-right">
                                                    เค้กชั้นบน
                                                </td>
                                            </tr>
                                        </tbody>
                                    </v-simple-table>
                                    <!-- <v-btn
                                        text
                                        color="warning"
                                        large
                                        block
                                    >
                                        <v-icon left>edit</v-icon>
                                        แก้ไขรายการ
                                    </v-btn> -->
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-card-text>
            </v-card>
        </v-col>
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
                    text: "ดึงเงิน",
                    fee: 100.0,
                    remark: "สูงสุด 20 แบงค์",
                    max: 20,
                    min: 1,
                },
                {
                    id: 2,
                    text: "ล้อมเงิน",
                    fee: 100.0,
                    remark: "1:35,2:40,3:45 *ปอนด์:แบงค์*",
                    max: 45,
                    min: 35,
                },
                {
                    id: 3,
                    text: "ลูกบอลใส่เงิน",
                    fee: 100.0,
                    remark: "สูงสุด 10 แบงค์",
                    max: 10,
                    min: 1,
                },
                {
                    id: 4,
                    text: "ซ่อนเงิน",
                    fee: 100.0,
                    remark: "สูงสุด 99 แบงค์",
                    max: 99,
                    min: 1,
                },
            ],
            cash: {
                option_id: "",
                text: "",
                fee: "",
                remark: "",
                max: "",
                min: "",
                note: "",
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
            this.cash.max = e.max;
            this.cash.min = e.min;
        },
        exit() {
            this.dialog = false;
            this.option = "";
            this.cash = {
                option_id: "",
                text: "",
                fee: "",
                remark: "",
                max: "",
                min: "",
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
