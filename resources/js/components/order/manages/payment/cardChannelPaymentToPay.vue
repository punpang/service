<template>
    <div>
        <v-dialog
            persistent
            width="400"
            transition="dialog-top-transition"
            v-model="dialog"
        >
            <template v-slot:activator="{ on }">
                <v-btn
                    @click="start"
                    v-on="on"
                    :large="propLarger"
                    :block="propBlock"
                    class="warning"
                    :disabled="
                        propAmount > order.sum_all.sumBalance ||
                        order.sum_all.sumBalance <= 0
                    "
                >
                    <strong>ชำระเงิน</strong>
                    <v-icon right>receipt</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ช่องทางชำระเงิน
                    <v-spacer></v-spacer>
                    <v-btn
                        icon
                        fab
                        x-small
                        class="white"
                        @click="dialog = false"
                    >
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-4">
                    <v-card outlined class="mb-3">
                        <v-card-text>
                            <v-checkbox
                                v-model="alertSMS"
                                label="แจ้งเตือนลูกค้า (SMS)"
                                hide-details
                                class="mt-0"
                            ></v-checkbox>
                            <v-checkbox
                                v-model="getGoods"
                                label="รับสินค้า"
                                hide-details
                                v-if="order.status == 8"
                            ></v-checkbox>
                            <v-checkbox
                                v-model="is_add_score"
                                label="สะสมคะแนนได้"
                                hide-details
                                v-if="order.status == 8"
                            ></v-checkbox>
                        </v-card-text>
                    </v-card>
                    <v-btn
                        v-for="useChannelPayment in useChannelPayments"
                        :key="useChannelPayment.id"
                        class="mb-3"
                        dark
                        block
                        x-large
                        :color="useChannelPayment.color"
                        v-if="
                            useChannelPayment.status_use &&
                            useChannelPayment.id != 3
                        "
                        @click="clickSubmitPayment(useChannelPayment)"
                    >
                        <v-icon left>{{ useChannelPayment.icon }}</v-icon>
                        <strong> {{ useChannelPayment.text }}</strong>
                    </v-btn>
                    <!-- <v-btn block class="mb-3" color="green accent-4" dark x-large>
            <v-icon left>attach_money</v-icon>
            เงินสด</v-btn
          >
          <v-btn block class="mb-3" color="#003D6B" dark x-large>
            <v-icon left>account_balance</v-icon>
            ธนาคาร</v-btn
          >

          <v-btn block x-large class="deep-purple darken-4" dark>
            <v-icon left>more_horiz</v-icon>

            อื่น ๆ</v-btn
          > -->
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propAmount", "propLarger", "propBlock"],
    data() {
        return {
            dialog: false,
            alertSMS: true,
            getGoods: true,
            is_add_score: true,
            // btnPayments: [
            //   {
            //     id: 1,
            //     text: "เงินสด",
            //     icon: "attach_money",
            //     color: "green accent-4",
            //     status_use: 1,
            //   },
            //   {
            //     id: 2,
            //     text: "ธนาคาร",
            //     icon: "account_balance",
            //     color: "#003D6B",
            //     status_use: 1,
            //   },
            //   {
            //     id: 3,
            //     text: "อื่น ๆ",
            //     icon: "more_horiz",
            //     color: "deep-purple darken-44",
            //     status_use: 1,
            //   },
            // ],
        };
    },
    methods: {
        async start() {
            if (
                this.order.sum_all.sumMoneyCustomer > 0 ||
                this.order.order_delivery_service
            ) {
                if (
                    this.propAmount !=
                    this.order.sum_all.sumTASC - this.order.sum_all.sumDeposited
                ) {
                    this.$swal({
                        title: "ยอดชำระไม่ถูกต้อง",
                        text: "มีบริการบางอย่างที่ต้องชำระทั้งหมด",
                        icon: "error",
                        allowOutsideClick: false,
                        confirmButtonText: "รับทราบ",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.dialog = false;
                        }
                    });
                    return;
                }
            }
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getUseChannelPayments");
            loader.hide();
        },
        clickSubmitPayment(channel) {
            const data = {
                alertSMS: this.alertSMS,
                getGoods: this.getGoods,
                channel: channel,
                is_add_score: this.is_add_score,
            };
            this.$emit("emitClickSubmitPayment", data);

            this.dialog = false;
        },
    },
    async mounted() {},
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            useChannelPayments: "orderIndex/useChannelPayments",
        }),
    },
};
</script>
