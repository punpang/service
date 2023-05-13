<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="500"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="white" @click="clickSearch()">เชื่อมต่อ</v-btn>
            </template>

            <v-card>
                <v-card-text class="pa-5">
                    <v-row>
                        <v-col cols="12" md="8" class="pb-0">
                            <v-text-field
                                v-model="search"
                                outlined
                                hide-details
                                label="ค้นหา"
                                placeholder="พิมพ์ชื่อเฟสบุค"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-btn
                                block
                                class="info"
                                x-large
                                @click="clickSearch()"
                            >
                                <v-icon left>search</v-icon>
                                ค้นหา</v-btn
                            >
                        </v-col>
                    </v-row>
                    <v-data-table
                        class="mt-2"
                        :headers="headers"
                        :items="profiles"
                        hide-default-footer
                        mobile-breakpoint="0"
                        :search="search"
                    >
                        <template v-slot:item.connect="{ item }">
                            <v-btn
                                class="success"
                                @click="clickConnect(item)"
                                :disabled="item.customer_id != NULL"
                            >
                                <v-icon left>link</v-icon>
                                เชื่อมต่อ</v-btn
                            >
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
˝
<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            search: "",
            dialog: false,
            headers: [
                {
                    text: "ชื่อเฟสบุค",
                    value: "full_name",
                },
                {
                    text: "เชื่อมต่อ",
                    value: "connect",
                    align: "end",
                },
            ],
        };
    },
    methods: {
        async clickSearch() {
            let loader = this.$loading.show();
            const payload = {
                params: `name=${this.search}&isNullCustomer=true`,
            };

            const result = await this.$store.dispatch(
                "facebook/searchProfile",
                payload
            );
            loader.hide();
        },
        async clickConnect(profile) {
            let loader = this.$loading.show();
            const payload = {
                profile: profile,

                customer_id: this.order.customer.id,
            };
            const result = await this.$store.dispatch(
                "facebook/connectProfile",
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
            this.dialog = false;
        },
    },
    computed: {
        ...mapGetters({
            profiles: "facebook/profiles",
            order: "orderIndex/order",
        }),
    },
};
</script>
