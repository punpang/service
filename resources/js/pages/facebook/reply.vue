<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="replys"
            :search="search"
            :items-per-page="20"
            hide-default-footer
            mobile-breakpoint="0"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>คำตอบอัตโนมัติ</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-text-field
                        v-model="search"
                        outlined
                        hide-details
                        label="ค้นหา"
                    ></v-text-field>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <!-- <v-spacer></v-spacer> -->
                    <create :propMethodCreate="true"></create>
                </v-toolbar>
            </template>
            <template v-slot:item.count_question="{ item }">
                {{ item.webhooks.length }}
            </template>
            <template v-slot:item.manages="{ item }">
                <match :propReply="item"></match>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import create from "@/js/components/facebook/reply/create";
import match from "@/js/components/facebook/reply/match";
export default {
    components: {
        create,
        match,
    },
    data() {
        return {
            search: "",
            headers: [
                {
                    text: "คำตอบ",
                    align: "start",
                    value: "text_th",
                },
                {
                    text: "จำนวนคำถาม",
                    align: "center",
                    value: "count_question",
                },
                {
                    text: "การจัดการ",
                    value: "manages",
                    align: "end",
                },
            ],
        };
    },
    methods: {
        async start() {
            let loader = this.$loading.show();
            const result = await this.$store.dispatch("facebook/fetch");
            loader.hide();
        },
    },
    async mounted() {
        await this.start();
    },
    computed: {
        ...mapGetters({
            replys: "facebook/fetch",
        }),
    },
};
</script>
