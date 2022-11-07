<template>
    <div>
        <v-card
            outlined
            v-for="moneyService in propMoneyService"
            :key="moneyService.id"
            class="my-2"
        >
            <v-card-title class="body-1 font-weight-bold"
                >บริการเสริม : {{ moneyService.category_money_service.text }}
                <v-spacer></v-spacer>
                <btnEditMoneyService
                    v-if="user.type == 1"
                    :propMoneyService="moneyService"
                ></btnEditMoneyService>
            </v-card-title>
            <v-card-text class="subtitle-1 pb-6">
                <!-- <p class="mb-0 font-weight-black">
                    {{ moneyService.sum_money_format }} บาท ({{
                        moneyService.sum_bank_notes
                    }}/{{ moneyService.category_money_service.max }})
                </p>
                <p class="caption font-weight-black red--text mb-0">
                    ค่าบริการ {{ moneyService.fee }} บาท
                </p>

                <ul class="mb-0">
                    <li>20 x {{ moneyService.thb20 }}</li>
                    <li>50 x {{ moneyService.thb50 }}</li>
                    <li>100 x {{ moneyService.thb100 }}</li>
                    <li>500 x {{ moneyService.thb500 }}</li>
                    <li>1,000 x {{ moneyService.thb1000 }}</li>
                </ul> -->

                <v-row>
                    <v-col cols="12" md="6" class="py-0">
                        <v-simple-table dense>
                            <tbody>
                                <tr>
                                    <td>20 บาท</td>
                                    <td class="text-right">
                                        {{ moneyService.thb20 }} แบงค์
                                    </td>
                                </tr>
                                <tr>
                                    <td>50 บาท</td>
                                    <td class="text-right">
                                        {{ moneyService.thb50 }} แบงค์
                                    </td>
                                </tr>
                                <tr>
                                    <td>100 บาท</td>
                                    <td class="text-right">
                                        {{ moneyService.thb100 }} แบงค์
                                    </td>
                                </tr>
                                <tr>
                                    <td>500 บาท</td>
                                    <td class="text-right">
                                        {{ moneyService.thb500 }} แบงค์
                                    </td>
                                </tr>
                                <tr>
                                    <td>1,000 บาท</td>
                                    <td class="text-right">
                                        {{ moneyService.thb1000 }} แบงค์
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </v-col>
                    <v-col cols="12" md="6" class="py-0">
                        <v-simple-table dense>
                            <tbody>
                                <tr>
                                    <td>จำนวนแบงค์</td>
                                    <td class="text-right">
                                        {{ moneyService.sum_bank_notes }} แบงค์
                                    </td>
                                </tr>
                                <tr>
                                    <td>จำนวนเงิน</td>
                                    <td class="text-right">
                                        {{ moneyService.sum_money_format }} บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td>ค่าบริการ</td>
                                    <td class="text-right">
                                        {{ moneyService.fee_format }} บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td>รวม</td>
                                    <td class="text-right">
                                        {{ moneyService.total_money }} บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td>หมายเหตุ</td>
                                    <td class="text-right">
                                        {{ moneyService.note }}
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import btnEditMoneyService from "@/js/components/order/manages/goods/cake/moneyService/btnEdit";
import { mapGetters } from "vuex";
export default {
    props: ["propMoneyService"],
    components: { btnEditMoneyService },
    computed: {
        ...mapGetters({
            user: "main/User",
        }),
    },
};
</script>

<style></style>
