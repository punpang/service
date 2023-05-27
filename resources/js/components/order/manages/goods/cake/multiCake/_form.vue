<template>
    <div>
        <v-card>
            <v-card-title class="text-h6">
                เชื่อมเค้กหลายชั้น
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="error">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <!-- {{ propOrderDetail.multi_cakes }} -->

                <v-data-table
                    :headers="headers"
                    :items="propOrderDetail.multi_cakes"
                    v-sortable-data-table
                    @sorted="saveOrder"
                    mobile-breakpoint="0"
                    item-key="id"
                    :items-per-page="-1"
                    hide-default-footer
                >
                    <template v-slot:item.manage="{ item }">
                        <v-btn
                            icon
                            fab
                            x-small
                            @click="clickRemove(item)"
                            v-if="item.id != item.order_detail_id"
                        >
                            <v-icon color="error">delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>

                <v-divider></v-divider>

                <v-item-group multiple>
                    <v-container>
                        <v-row>
                            <v-col
                                v-for="detail in order.order_details"
                                :key="detail.id"
                                cols="12"
                                md="12"
                                v-if="
                                    detail.order_detail_id == null &&
                                    detail.id != propOrderDetail.id
                                "
                            >
                                <v-item>
                                    <v-card
                                        color="orange"
                                        class="d-flex align-center"
                                        dark
                                        height="100"
                                        @click="addMulticake(detail)"
                                    >
                                        <v-scroll-y-transition>
                                            <!-- <div
                                                v-if="active"
                                                class="flex-grow-1 text-center"
                                            >
                                                {{ detail.a_price.name_goods }}
                                            </div> -->
                                            <div
                                                class="text-h6 flex-grow-1 text-center"
                                            >
                                                {{ detail.a_price.name_goods }}
                                            </div>
                                        </v-scroll-y-transition>
                                    </v-card>
                                </v-item>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-item-group>
            </v-card-text>
            <!-- <v-card-actions>
                <v-btn class="error" @click="exit()">
                    <v-icon left>exit_to_app</v-icon>
                    ออก
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn class="success">
                    <v-icon left>save</v-icon>
                    บันทึก
                </v-btn>
            </v-card-actions> -->
        </v-card>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
import { mapGetters } from "vuex";
import Sortable from "sortablejs";
export default {
    props: ["propOrderDetail", "propOrder"],
    components: {},
    data() {
        return {
            dialog: false,
            headers: [
                {
                    text: "ชื่อสินค้า",
                    align: "start",
                    value: "a_price.name_goods",
                },
                {
                    text: "ชั้น",
                    align: "center",
                    value: "sort_group_multi_cake",
                },

                {
                    text: "การจัดการ",
                    align: "end",
                    value: "manage",
                },
            ],
        };
    },
    methods: {
        async addMulticake(item) {
            let loader = this.$loading.show();
            const payload = {
                detail_id: item.id,
                order_detail_id: this.propOrderDetail.id,
            };

            const result = await this.$store.dispatch(
                "orderIndex/add_multi_cake",
                payload
            );
            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.$route.params.id,
                });
                this.$toast.success(result.data.text);
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางอย่าง");
            }

            loader.hide();
        },
        async clickRemove(item) {
            let loader = this.$loading.show();
            const payload = {
                detail_id: item.id,
            };

            // const index = this.propOrderDetail.multi_cakes.splice(
            //     this.propOrderDetail.multi_cakes.indexOf(item)
            // );

            // console.log(index);

            const result = await this.$store.dispatch(
                "orderIndex/remove_muticake",
                payload
            );

            if (result.status == 200) {
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.$route.params.id,
                });
                // this.propOrderDetail.multi_cakes.splice(
                //     this.propOrderDetail.multi_cakes.indexOf(item),
                //     1
                // );

                // for (
                //     let i = 0;
                //     i < this.propOrderDetail.multi_cakes.length;
                //     i++
                // ) {
                //     this.propOrderDetail.multi_cakes[i].sort_group_multi_cake =
                //         i + 1;
                // }

                // if (this.propOrderDetail.multi_cakes.length == 1) {
                //     this.propOrderDetail.multi_cakes = [];
                // }
                this.$toast.success(result.data.text);
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางอย่าง");
            }

            loader.hide();
        },
        exit() {
            // let loader = this.$loading.show();
            this.$emit("emitExit");
        },
        async saveOrder(event) {
            let loader = this.$loading.show();
            const movedItem = await this.propOrderDetail.multi_cakes.splice(
                event.oldIndex,
                1
            )[0];
            await this.propOrderDetail.multi_cakes.splice(
                event.newIndex,
                0,
                movedItem
            );
            const minimum =
                event.newIndex < event.oldIndex
                    ? event.newIndex
                    : event.oldIndex;

            const maximum =
                event.oldIndex > event.newIndex
                    ? event.oldIndex
                    : event.newIndex;

            let data = [];
            for (let i = minimum; i < maximum + 1; i++) {
                this.propOrderDetail.multi_cakes[i].sort_group_multi_cake =
                    i + 1;
                // data.push(this.propOrderDetail.multi_cakes[i]);
                data.push({
                    detail_id: this.propOrderDetail.multi_cakes[i].id,
                    sort_group_multi_cake:
                        this.propOrderDetail.multi_cakes[i]
                            .sort_group_multi_cake,
                });
            }

            const payload = data;

            const result = await this.$store.dispatch(
                "orderIndex/update_sort_group_multi_cake",
                payload
            );

            if (result.status == 200) {
                this.$toast.success(result.data.text);
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางอย่าง");
            }

            loader.hide();
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
    mounted() {},
    directives: {
        sortableDataTable: {
            bind(el, binding, vnode) {
                const options = {
                    animation: 150,
                    onUpdate: function (event) {
                        vnode.child.$emit("sorted", event);
                    },
                };
                Sortable.create(el.getElementsByTagName("tbody")[0], options);
            },
        },
    },
};
</script>
