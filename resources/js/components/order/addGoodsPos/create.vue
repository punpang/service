<template>
    <div>
        <v-dialog persistent width="800" v-model="dialog" scrollable>
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
                                POS
                            </div>
                        </v-scroll-y-transition>
                    </v-card>
                </v-item>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    สินค้า POS

                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small>
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <tablePosGoods :propPosGoods="propPosGoods"></tablePosGoods>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import tablePosGoods from "@/js/components/pos/goods/table";
import { mapGetters } from "vuex";
export default {
    props: ["propPosGoods"],
    components: {
        tablePosGoods,
    },
    data() {
        return {
            dialog: false,
        };
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
<style></style>
