<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="350"
            scrollable
            persistent
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item
                    v-on="on"
                    @click="clickStart()"
                    :disabled="order.sum_all.usePoint != 0"
                >
                    <!-- ||
                        (order.sum_all.sumBalance != 0 &&
                            !order.order_delivery_service) -->
                    <v-list-item-title class="py-1">
                        ใช้คะแนนสะสม
                        <div class="text-caption error--text">
                            {{
                                order.sum_all.usePoint != 0
                                    ? `ใช้คะแนนสะสม ${-order.sum_all
                                          .usePoint} คะแนน`
                                    : ""
                            }}
                        </div>
                    </v-list-item-title>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ใช้คะแนนสะสม
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="clickExit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-6">
                    <v-text-field
                        outlined
                        hide-details
                        v-model="use_point"
                        type="number"
                        :label="`คำสั่งซื้อนี้ใช้ได้ ${available_points} คะแนน`"
                        :append-icon="use_point == 0 ? 'add_circle' : 'cancel'"
                        @click:append="
                            use_point == 0
                                ? clickAvailablePoints()
                                : (use_point = 0)
                        "
                        autofocus
                        pattern="\d*"
                    ></v-text-field>
                    <!-- <v-btn @click="clickTest()" block x-large>ทดสอบคะแนน</v-btn> -->
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        class="success"
                        block
                        x-large
                        :disabled="use_point == 0"
                        @click="clickSave()"
                        >ใช้เลย</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            dialog: false,
            use_point: 0,
        };
    },
    methods: {
        clickExit() {
            this.dialog = false;
            this.use_point = 0;
        },
        async getData() {
            let loader = this.$loading.show();
            
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });
            loader.hide();
        },

        async clickStart() {
            await this.getData();
            this.use_point = 0;
            // await this.clickSave();
        },
        clickAvailablePoints() {
            this.use_point = this.available_points;
            // 250 >= 648
            // if (
            //     this.order.sum_all.sumGoods / 2 >=
            //     this.order.customer.sum_diff_score
            // ) {
            //     this.use_point = this.order.customer.sum_diff_score;
            // } else {
            //     // 250 < 648
            //     this.use_point = parseInt(this.order.sum_all.sumGoods / 2);
            // }

            // // 250 >= 648
            // if (
            //     this.order.sum_all.sumGoods >=
            //     this.order.customer.sum_diff_score
            // ) {
            //     this.use_point = this.order.customer.sum_diff_score;
            // }
            // // 250 < 648
            // else {
            //     this.use_point = this.order.sum_all.sumGoods;
            // }
        },
        async clickSave() {
            let loader = this.$loading.show();

            if (this.use_point == 0) {
                return;
            }

            const payload = {
                point: this.use_point,
                order_id: this.order.id,
            };

            const result = await this.$store.dispatch(
                "orderIndex/use_point_by_order_id",
                payload
            );

            if (result.status == 200) {
                if (result.data.icon == "success") {
                    this.$toast.success(result.data.text);
                } else {
                    this.$toast.error(result.data.text);
                }
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ");
            }

            await this.getData();
            this.dialog = false;
            loader.hide();
        },
        async save() {},
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),

        available_points() {
            if (
                this.order.sum_all.sumGoods / 2 >=
                this.order.customer.sum_diff_score
            ) {
                return this.order.customer.sum_diff_score;
            } else {
                // 250 < 648
                return parseInt(this.order.sum_all.sumGoods / 2);
            }
        },
    },
};
</script>
