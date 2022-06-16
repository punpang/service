<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="500"
            scrollable
            persistent
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item
                    v-on="on"
                    @click="clickStart()"
                    v-if="order.status == 8"
                    :disabled="
                        order.sum_all.sumBalance != 0
                    "
                >
                    <!-- ||
                        (order.sum_all.sumBalance != 0 &&
                            !order.order_delivery_service) -->
                    <v-list-item-title class="py-1">
                        รับสินค้า

                        <div class="text-caption error--text">
                            <!-- {{
                                order.order_delivery_service.status !=
                                    "success" &&
                                order.order_delivery_service.id > 0
                                    ? "จัดส่งยังไม่สำเร็จ"
                                    : ""
                            }} -->
                            {{
                                order.status != 8
                                    ? "สถานะไม่ถูกต้อง (เตรียมสินค้า)"
                                    : ""
                            }}
                            {{
                                order.sum_all.sumBalance != 0
                                    ? "ยอดคงเหลือไม่เท่ากับ 0"
                                    : ""
                            }}
                        </div>
                    </v-list-item-title>
                </v-list-item>
            </template>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        async getData() {
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });
            loader.hide();
        },

        async clickStart() {
            //await this.getData();
            await this.clickSave();
        },
        clickSave() {
            this.$swal({
                title: "รับสินค้า",
                text: "ลูกค้าได้รับสินค้าแล้วใช่ไหม",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่ , ได้รับแล้ว",
                cancelButtonText: "ไมใช่ , ยังไม่ได้รับ",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.save();
                }

                this.dialog = false;
            });
        },
        async save() {
            let loader = this.$loading.show();
            const result = await this.$store.dispatch(
                "orderIndex/pickUpGoods",
                {
                    order_id: this.$route.params.id,
                }
            );
            this.$swal({
                title: result.data.title,
                text: result.data.message,
                icon: result.data.icon,
                allowOutsideClick: false,
                timer: 3000,
                timerProgressBar: true,
                confirmButtonText: "รับทราบ",
                confirmButtonColor: "#3085d6",
            });
            await this.getData();
            loader.hide();
            // return result;
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
