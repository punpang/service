<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="400"
            scrollable
            persistent
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-title class="py-1">
                        เชื่อมต่อบัญชีโซเชียล
                    </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <v-card-title class="text-h6 white--text warning"
                    >เชื่อมต่อบัญชีโซเชียล
                    <v-spacer></v-spacer>
                    <v-btn fab x-small icon color="white" @click="emitExit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pa-5">
                    <v-row>
                        <v-col cols="6" class="px-4 pt-3 pb-2">
                            <strong class="h4 mb-0 mt-2">Facebook</strong>
                        </v-col>
                        <v-col
                            cols="6"
                            class="text-right py-2 px-4"
                            small
                            outlined
                        >
                            <searchFacebook
                                v-if="!order.customer.facebook"
                            ></searchFacebook>
                            <v-btn
                                class="error"
                                v-else
                                @click="clickDisconnectFacebook()"
                                >ยกเลิกเชื่อมต่อ</v-btn
                            >
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6" class="px-4 pt-3 pb-2">
                            <strong class="h4">Line</strong>
                        </v-col>
                        <v-col
                            cols="6"
                            class="text-right py-2 px-4"
                            small
                            outlined
                        >
                            <searchLine
                                v-if="!order.customer.line"
                            ></searchLine>
                            <v-btn
                                class="error"
                                v-else
                                @click="clickDisconnectLine()"
                                >ยกเลิกเชื่อมต่อ</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import searchFacebook from "@/js/components/order/connectSocialProfile/searchFacebook";
import searchLine from "@/js/components/order/connectSocialProfile/searchLine";
export default {
    components: { searchFacebook, searchLine },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitExit() {
            this.dialog = false;
        },

        async clickDisconnectFacebook() {
            let loader = this.$loading.show();
            const payload = {
                facebook_id: this.order.customer.facebook.id,
                customer_id: this.order.customer.id,
            };

            const result = await this.$store.dispatch(
                "facebook/disconnectProfile",
                payload
            );

            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.order.id,
            });

            loader.hide();

            await this.$swal({
                toast: true,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                icon: result.data.icon,
                title: result.data.title,
                position: "bottom",
            });
        },
        async clickDisconnectLine() {
            // let loader = this.$loading.show();
            const payload = {
                line_id: this.order.customer.line.id,
                customer_id: this.order.customer.id,
            };

            console.log(payload);
            // return;

            const result = await this.$store.dispatch(
                "line/disconnectProfile",
                payload
            );

            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.order.id,
            });

            loader.hide();

            await this.$swal({
                toast: true,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                icon: result.data.icon,
                title: result.data.title,
                position: "bottom",
            });
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
