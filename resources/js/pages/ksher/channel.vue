<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="fetchs"
            mobile-breakpoint="0"
            :loading="loading_table"
            hide-default-footer
            item-key="id"
            v-sortable-data-table
            @sorted="saveOrder"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>ช่องทางชำระเงิน</v-toolbar-title>
                </v-toolbar>
            </template>
            <template v-slot:item.mi-maximum="{ item }">
                {{ item.minimum }} - {{ item.maximum }}
            </template>
            <template v-slot:item.text="{ item }">
                <v-switch
                    v-model="item.status_use"
                    inset
                    :label="item.text"
                    @click="update_status_use(item)"
                ></v-switch>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import Sortable from "sortablejs";

export default {
    data() {
        return {
            headers: [
                { text: "ลำดับ", value: "sort" },
                { text: "ชื่อ", value: "text" },
                { text: "channel", value: "channel" },
                { text: "ต่ำสุด-สูงสุด", value: "mi-maximum" },
                { text: "ค่าธรรมเนียม", value: "remark" },
                // { text: "สถานะ", value: "status", align: "end" },
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
        async update_status_use(i) {
            let loader = this.$loading.show();
            const payload = {
                ksher: i,
            };
            await this.$store.dispatch("orderKsher/update_status_use", payload);
            loader.hide();
        },
        async saveOrder(event) {
            let loader = this.$loading.show();
            const movedItem = await this.fetchs.splice(event.oldIndex, 1)[0];
            await this.fetchs.splice(event.newIndex, 0, movedItem);
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
                this.fetchs[i].sort = i + 1;
                data.push(this.fetchs[i]);
            }
            const payload = {
                sort: data,
            };

            await this.$store.dispatch("orderKsher/update_sort", payload);

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
