<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="fetchs"
            :items-per-page="20"
            hide-default-footer
            mobile-breakpoint="0"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>วันหยุดร้าน</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>

                    <v-spacer></v-spacer>
                    <btnCreateDayOff
                        @emitSuccess="emitSuccess"
                    ></btnCreateDayOff>
                </v-toolbar>
            </template>
            <template v-slot:item.start_date_th="{ item }">
                {{
                    item.start_date_th != item.end_date_th
                        ? item.start_date_th + " - " + item.end_date_th
                        : item.start_date_th
                }}
            </template>
            <template v-slot:item.manages="{ item }">
                <v-icon color="error" @click="remove(item.id)">delete</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import btnCreateDayOff from "@/js/components/store/btnCreateDayOff";
export default {
    components: { btnCreateDayOff },
    data() {
        return {
            fetchs: [],
            headers: [
                { text: "วันที่เริ่มต้น-สิ้นสุด", value: "start_date_th" },
                { text: "การจัดการ", value: "manages", align: "end" },
            ],
        };
    },
    methods: {
        async fetch() {
            let loader = this.$loading.show();
            const result = await axios.get(
                `/api/admin/v1/StoreDayOff/fetch?isManage=true`
            );
            this.fetchs = result.data;
            loader.hide();
        },
        async remove(id) {
            let loader = this.$loading.show();
            await axios.post(`/api/admin/v1/StoreDayOff/${id}/remove`);
            await this.fetch();
            loader.hide();
        },
        async emitSuccess() {
            await this.fetch();
        },
    },
    async mounted() {
        await this.fetch();
    },
};
</script>

<style></style>
