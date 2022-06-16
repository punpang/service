<template>
    <div>
        <v-dialog v-model="dialog" persistent scrollable width="500">
            <template v-slot:activator="{ on }">
                <v-btn class="info" small v-on="on" @click="clickFetch()">
                    <v-icon left>assessment</v-icon>
                    ข้อมูล
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white" dark>
                    <v-icon left>assessment</v-icon>ข้อมูล
                    <v-spacer></v-spacer>
                    <v-btn
                        fab
                        x-small
                        icon
                        color="error"
                        @click="dialog = false"
                    >
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pa-4">
                    <v-alert color="info" prominent text class="pt-2">
                        <v-row align="center" class="ma-0">
                            <strong class="h4 mb-0">คำตอบ</strong> <br />
                            <v-spacer></v-spacer>
                            <create
                                :propMethodUpdate="true"
                                :propReply="propReply"
                            ></create>
                        </v-row>

                        <v-divider class="mt-3 mb-2 info"></v-divider>

                        {{ propReply.text_th }}
                    </v-alert>
                    <v-text-field
                        label="ค้นหา"
                        v-model="search"
                        outlined
                        hide-details
                        dense
                    ></v-text-field>
                    <v-data-table
                        :headers="headers"
                        :items="propReply.webhooks"
                        :search="search"
                        hide-default-footer
                        :items-per-page="10"
                        mobile-breakpoint="0"
                    >
                        <template v-slot:item.manages="{ item }">
                            <v-icon color="error " @click="clickRemove(item)"
                                >delete</v-icon
                            >
                        </template>
                    </v-data-table>

                    <v-divider class="my-2"></v-divider>
                    <v-divider class="mt-2 mb-4"></v-divider>
                    <strong class="h4">คำถามใหม่</strong> <br />
                    <v-data-table
                        hide-default-footer
                        hide-default-header
                        :headers="headers"
                        :items="fetchWebhooks"
                        :search="search"
                        :items-per-page="100"
                        mobile-breakpoint="0"
                    >
                        <template v-slot:item.manages="{ item }">
                            <v-icon color="success" @click="clickAdd(item)"
                                >add</v-icon
                            >
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import create from "@/js/components/facebook/reply/create";
export default {
    props: ["propReply"],
    components: { create },
    data() {
        return {
            dialog: false,
            search: "",
            headers: [
                {
                    text: "คำถาม",
                    align: "start",
                    value: "message",
                },
                {
                    text: "การจัดการ",
                    align: "end",
                    value: "manages",
                },
            ],
        };
    },
    methods: {
        async clickFetch() {
            const payload = {
                isNullReply: true,
            };
            const result = await this.$store.dispatch(
                "facebook/fetchWebhook",
                payload
            );
        },
        async clickAdd(webhook) {
            let loader = this.$loading.show();
            const payload = {
                webhook: webhook,
                reply: this.propReply,
            };

            const result = await this.$store.dispatch(
                "facebook/addReplyToWebhook",
                payload
            );

            await this.$store.dispatch("facebook/fetch");
            await this.clickFetch();

            loader.hide();

            this.$swal({
                toast: true,
                timerProgressBar: true,
                timer: 3000,
                title: result.data.title,
                showConfirmButton: false,
                icon: result.data.icon,
                position: "bottom",
            });
        },
        async clickRemove(webhook) {
            let loader = this.$loading.show();
            const payload = {
                webhook: webhook,
            };

            const result = await this.$store.dispatch(
                "facebook/removeReplyOfWebhook",
                payload
            );

            await this.$store.dispatch("facebook/fetch");
            await this.clickFetch();

            loader.hide();

            this.$swal({
                toast: true,
                timerProgressBar: true,
                timer: 3000,
                title: result.data.title,
                showConfirmButton: false,
                icon: result.data.icon,
                position: "bottom",
            });
        },
    },
    computed: {
        ...mapGetters({
            fetchWebhooks: "facebook/fetchWebhook",
        }),
    },
};
</script>
