<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="fetchs"
            mobile-breakpoint="0"
            :loading="loading_table"
            hide-default-footer
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>ช่องทางชำระเงิน</v-toolbar-title>
                </v-toolbar>
            </template>
            <template v-slot:item.mi-maximum="{ item }">
                {{ item.minimum }} - {{ item.maximum }}
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            headers: [
                { text: "ชื่อ", value: "text" },
                { text: "channel", value: "channel" },
                { text: "ต่ำสุด-สูงสุด", value: "mi-maximum" },
                { text: "ค่าธรรมเนียม", value: "remark" },
                // { text: "การจัดการ", value: "manages", align: "end" },
            ],
            loading_table: false,
        };
    },
    methods: {
        async fetch() {
            let loader = this.$loading.show();
            this.loading_table = true;
            const result = await this.$store.dispatch("orderKsher/fetch", {
                params: "orderByASC=sort",
            });
            this.loading_table = false;
            loader.hide();
        },
    },
    async mounted() {
        await this.fetch();
    },
    computed: {
        ...mapGetters({
            fetchs: "orderKsher/ksherPay",
        }),
    },
};
</script>
