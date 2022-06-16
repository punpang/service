<template>
    <div>
        <v-dialog persistent width="350" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" @click="fetchChannels()"> ดำเนินการ</v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ปรับยอดชำระเงินส่วนเกิน
                    <v-spacer></v-spacer>
                    <v-btn
                        icon
                        fab
                        x-small
                        class="white"
                        @click="dialog = false"
                    >
                        <v-icon class="warning--text">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pa-4">
                    <v-row class="text-subtitle-1">
                        <v-col cols="6">จำนวนเงินส่วนเกิน</v-col>
                        <v-col cols="6" class="text-right">
                            {{ order.sum_all.sumBalance }} บาท</v-col
                        >
                    </v-row>

                    <v-divider></v-divider>

                    <v-btn
                        v-for="option in channelOptions"
                        :key="option.id"
                        x-large
                        :class="option.class"
                        dark
                        block
                        @click="setPoint(option)"
                    >
                        <v-icon left>{{ option.icon }}</v-icon>
                        {{ option.text }}
                    </v-btn>

                    <!-- <v-btn
                        x-large
                        class="indigo darken-4 mb-2"
                        dark
                        block
                        @click="setPoint()"
                    >
                        <v-icon left>add</v-icon>
                        คะแนนสะสม
                    </v-btn>
                    <v-btn x-large class="blue darken-4 mb-2" dark block>
                        <v-icon left>attach_money</v-icon>
                        เงินสด
                    </v-btn>
                    <v-btn x-large class="cyan darken-4 mb-2" dark block>
                        <v-icon left>account_balance</v-icon>
                        ธนาคาร
                    </v-btn> -->
                    <v-btn
                        x-large
                        class="error mb-2"
                        dark
                        block
                        @click="dialog = false"
                    >
                        <v-icon left>exit_to_app</v-icon>
                        ออกจากหน้านี้
                    </v-btn>
                    <!-- --- -->
                    <!-- <v-row>
                        <v-col cols="12" md="4"
                            ><v-item>
                                <v-card
                                    color="white"
                                    class="d-flex align-center grey warning"
                                    dark
                                    height="100"
                                >
                                    <v-scroll-y-transition>
                                        <div
                                            class="text-h5 flex-grow-1 text-center"
                                        >
                                            คะแนนสะสม
                                        </div>
                                    </v-scroll-y-transition>
                                </v-card>
                            </v-item></v-col
                        >
                        <v-col cols="12" md="4"
                            ><v-item>
                                <v-card
                                    color="white"
                                    class="d-flex align-center grey warning"
                                    dark
                                    height="100"
                                >
                                    <v-scroll-y-transition>
                                        <div
                                            class="text-h6 flex-grow-1 text-center"
                                        >
                                            เงินสด
                                        </div>
                                    </v-scroll-y-transition>
                                </v-card>
                            </v-item></v-col
                        >
                        <v-col cols="12" md="4"
                            ><v-item>
                                <v-card
                                    color="white"
                                    class="d-flex align-center grey warning"
                                    dark
                                    height="100"
                                >
                                    <v-scroll-y-transition>
                                        <div
                                            class="text-h6 flex-grow-1 text-center"
                                        >
                                            ธนาคาร
                                        </div>
                                    </v-scroll-y-transition>
                                </v-card>
                            </v-item></v-col
                        >
                    </v-row> -->
                </v-card-text>
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
            // options: [
            //     {
            //         id: 1,
            //         text: "คะแนน",
            //         name: "point",
            //         icon: "add",
            //         class: "indigo darken-4 mb-2",
            //     },
            //     {
            //         id: 2,
            //         text: "เงินสด",
            //         name: "cash",
            //         icon: "attach_money",
            //         class: "blue darken-4 mb-2",
            //     },
            //     {
            //         id: 3,
            //         text: "ธนาคาร",
            //         name: "bank",
            //         icon: "account_balance",
            //         class: "cyan darken-4 mb-2",
            //     },
            // ],
        };
    },
    methods: {
        async fetchChannels() {
            let loader = this.$loading.show();
            const result = await this.$store.dispatch(
                "orderAdjustExcessPayment/fetchChannels"
            );
            if (result.status == 200) {
                // this.$swal(result.data.sweetAlert);
                // this.$swal({
                //     icon: result.data.icon,
                //     title: result.data.title,
                //     text: result.data.text,
                //     // timer: 5000,
                //     // timerProgressBar: true,
                //     showConfirmButton: false,
                //     // toast: true,
                //     position: "bottom-end",
                // });
                this.$toast.success("โหลดข้อมูลสำเร็จ");
                loader.hide();
            } else {
                this.$swal({
                    icon: "error",
                    title: "ผิดพลาด",
                    text: "เกิดข้อผิดพลาดบางประการ",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    toast: true,
                    position: "bottom-end",
                });
            }
        },
        setPoint(option) {
            this.$swal({
                title: `คืนเป็น ${option.text} ?`,

                // toast: true,
                // position: "top-end",
                // timer: 3000,
                // timerProgressBar: true,
                allowOutsideClick: false,
                confirmButtonText: "ใช่",
                cancelButtonText: "ไม่ใช่",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                icon: "warning",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.store(option);
                    // if (option.name == "point") {
                    // }

                    // if (option.name == "cash") {
                    // }

                    // if (option.name == "bank") {
                    // }
                }
            });
        },

        async store(option) {
            let loader = this.$loading.show();
            const payload = {
                order: this.order,
                option: option,
            };
            const response = await this.$store.dispatch(
                "orderAdjustExcessPayment/store",
                payload
            );

            this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.order.id,
            });

            loader.hide();

            this.$swal({
                title: response.data.title,
                text: response.data.message,
                icon: response.data.icon,
                allowOutsideClick: false,
                confirmButtonText: "รับทราบ",
                confirmButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.dialog = false;
                }
            });
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            channelOptions: "orderAdjustExcessPayment/fetchChannels",
        }),
    },
};
</script>
