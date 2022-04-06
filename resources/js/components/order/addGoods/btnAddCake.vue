<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            width="500"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-item>
                    <v-card
                        v-on="on"
                        color="white"
                        class="d-flex align-center grey warning"
                        dark
                        height="150"
                    >
                        <v-scroll-y-transition>
                            <div class="text-h4 flex-grow-1 text-center">
                                CAKE
                            </div>
                        </v-scroll-y-transition>
                    </v-card>
                </v-item>
            </template>

            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    {{ text.header }}
                </v-card-title>
                <v-card-text class="px-4 pt-4 pb-0">
                    <cardAPrice
                        :propAPrice="a_price"
                        v-if="a_price.id >= 1"
                    ></cardAPrice>
                    <v-alert type="warning" dense v-else
                        >โปรดเลือกสินค้าก่อน</v-alert
                    >
                    <!-- // -->
                    <formAddCake :propForm="formMD"></formAddCake>
                </v-card-text>
                <v-card-actions>
                    <selectCake
                        :propCheckProduct="a_price"
                        @emitAPrice="emitAPrice"
                        class="mb-3"
                    ></selectCake>

                    <v-spacer></v-spacer>
                    <v-btn class="error" @click="close()">
                        <v-icon left>
                            {{ msg.icon.clear }}
                        </v-icon>
                        ออก
                    </v-btn>
                    <v-btn class="success" @click="save()">
                        <v-icon left>
                            {{ msg.icon.save }}
                        </v-icon>
                        {{ msg.text.save }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import selectCake from "@/js/components/order/product/select/selectCake";
import cardAPrice from "@/js/components/order/product/select/cardAPirce";
import formAddCake from "@/js/components/order/addGoods/formAddCake";
import { mapGetters } from "vuex";
export default {
    components: { selectCake, cardAPrice, formAddCake },
    data() {
        return {
            dialog: false,
            text: {
                header: "เพิ่มสินค้า :: CAKE",
            },
            a_price: {},
            formMD: {
                message: "",
                detail: "",
            },
        };
    },
    methods: {
        emitAPrice(v) {
            this.a_price = v;
        },
        async save() {
            if (
                !this.formMD.message ||
                !this.formMD.detail ||
                this.a_price == {}
            ) {
                this.$toast.warning("โปรดกรอกข้อมูลให้ครบถ้วน");
                return;
            }

            this.a_price.message = this.formMD.message;
            this.a_price.detail = this.formMD.detail;
            const payload = {
                order_id: this.$route.params.id,
                a_price: this.a_price,
            };
            let loader = this.$loading.show();

            const result = await this.$store.dispatch(
                "orderIndex/addGoodsCake",
                payload
            );

            if (result.status == 200) {
                this.$toast.success(result.data.message);
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.$route.params.id,
                });
                this.close();
            } else {
                this.$toast.error(
                    "เกิดข้อผิดพลาดบางประการ โปรดลองใหม่อีกครั้ง"
                );
            }
            loader.hide();
        },
        async close() {
            this.a_price = {};
            this.formMD = {
                message: "",
                detail: "",
            };
            // await this.$store.dispatch("orderIndex/getOrderByID", {
            //     orderID: this.propOrderDetail.order_id,
            // });
            this.dialog = false;
        },
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
        }),
    },
};
</script>
