<template>
    <div>
        <!-- {{ fetchs }} -->
        <v-data-table
            :headers="headers"
            :items="fetchs"
            mobile-breakpoint="0"
            :loading="loading_table"
            hide-default-footer
            items-per-page="99"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>วันที่ปิดใช้งาน KSHER</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <dayOffCreate @emitSuccess="emitSuccess"> </dayOffCreate>
                </v-toolbar>
            </template>
            <template v-slot:item.manages="{ item }">
                <v-icon color="error" @click="clickRemove(item)">delete</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import dayOffCreate from "@/js/pages/ksher/dayOff/create";
export default {
    components: { dayOffCreate },
    data() {
        return {
            loading_table: false,
            headers: [
                {
                    text: "ช่องทางชำระเงิน",
                    value: "ksher_channel_payment.text",
                },
                { text: "วันที่ปิดใช้งาน", value: "day_off_th" },
                {
                    text: "การจัดการ",
                    value: "manages",
                    align: "end",
                },
            ],
        };
    },
    methods: {
        async emitSuccess() {
            await this.fetch();
        },
        async fetch() {
            let loader = this.$loading.show();
            this.loading_table = true;
            const payload = "isStartNow=true&sort_asc=day_off";
            const result = await this.$store.dispatch(
                "orderKsher/fetch_ksher_day_off",
                payload
            );
            this.loading_table = false;
            loader.hide();
        },
        async clickRemove(v) {
            let loader = this.$loading.show();
            const payload = {
                id: v.id,
            };
            const result = await this.$store.dispatch(
                "orderKsher/remove_ksher_day_off",
                payload
            );
            await this.fetch();
            loader.hide();
        },
    },
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapGetters({
            fetchs: "orderKsher/fetch_day_offs",
        }),
    },
};
</script>
