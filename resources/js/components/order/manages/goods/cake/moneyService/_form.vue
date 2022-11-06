<template>
    <div>
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
                                    cash.max < cashSum ? 'red white--text' : ''
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

                    <v-btn
                        text
                        color="error"
                        class="my-3"
                        large
                        block
                        v-if="this.propMoneyService"
                        @click="clickDelete()"
                    >
                        <v-icon left>delete</v-icon>
                        ลบรายการนี้
                    </v-btn>
                </v-col>
            </v-row>
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
                :disabled="cashSum <= 0 || thbSum <= 0 || cash.max < cashSum"
            >
                <v-icon left>save</v-icon>
                บันทึก
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    props: ["propOrderDetail", "propMoneyService"],
    components: {},
    data() {
        return {
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
                category_money_service_id: "",
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
            let loader = this.$loading.show();
            let result;
            if (!this.propMoneyService) {
                this.cash.order_detail_id = this.propOrderDetail.id;
                const payload = this.cash;
                result = await this.$store.dispatch(
                    "moneyServices/store",
                    payload
                );
                this.exit();
            } else {
                const payload = this.cash;
                result = await this.$store.dispatch(
                    "moneyServices/update",
                    payload
                );
                this.exitEdit();
            }

            let swal = {};
            if (result.status == 201) {
                swal = {
                    icon: "success",
                    title: "สร้างรายการสำเร็จ",
                };
            } else {
                swal = {
                    icon: "error",
                    title: "เกิดข้อผิดพลาดบางอย่าง",
                };
            }

            this.$swal({
                toast: true,
                allowOutsideClick: false,
                icon: swal.icon,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                title: swal.title,
                position: "bottom",
            });

            loader.hide();
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
            this.cash.category_money_service_id = e.id;
            this.cash.text = e.text;
            this.cash.remark = e.remark;
            this.cash.fee = e.fee;
            this.cash.max = e.max;
            this.cash.min = e.min;
        },
        exit() {
            if (this.propMoneyService) {
                this.exitEdit();
                return;
            }
            this.option = "";
            this.cash = {
                category_money_service_id: "",
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
            };
            this.$emit("emitExit");
        },
        exitEdit() {
            this.$emit("emitExit");
        },
        clickDelete() {
            this.$swal({
                title: "ลบข้อมูล",
                text: "ต้องการลบรายการนี้ใช่ไหม ?",
                icon: "warning",
                allowOutsideClick: false,
                confirmButtonColor: "#38c172",
                confirmButtonText: "ใช่, ลบข้อมูล",
                showDenyButton: true,
                denyButtonText: "ไม่ใช่, ออกจากหน้านี้",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete();
                }
            });
        },
        async delete() {
            let loader = this.$loading.show();
            const payload = this.propMoneyService;
            const result = await this.$store.dispatch(
                "moneyServices/delete",
                payload
            );
            if (result.status == 200) {
                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    icon: result.data.icon,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    title: result.data.title,
                    position: "bottom",
                });
            } else {
                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    title: "เกิดข้อผิดพลาดบางอย่าง",
                    position: "bottom",
                });
            }
            this.exitEdit();
            loader.hide();
        },
        async fecthCategoryMoneyService() {
            let loader = this.$loading.show();
            const result = await axios.get(
                "/api/admin/v1/categoryMoneyService/fetch"
            );
            this.options = result.data;
            loader.hide();
        },
        setCash() {
            this.option = this.propMoneyService.category_money_service_id;
            this.cash = this.propMoneyService;
            this.changeOption();
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
    mounted() {
        this.fecthCategoryMoneyService();

        if (this.propMoneyService) {
            this.setCash();
        }
    },
};
</script>
