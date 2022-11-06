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
                <btnEditMoneyService :propMoneyService="moneyService"></btnEditMoneyService>
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
                    <v-col cols="12" md="6">
                        <v-simple-table>
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
    </div>
</template>

<script>
import btnEditMoneyService from "@/js/components/order/manages/goods/cake/moneyService/btnEdit";
export default {
    props: ["propMoneyService"],
    components: { btnEditMoneyService },
};
</script>

<style></style>
