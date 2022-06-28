<template>
    <div>
        <v-row>
            <v-col cols="7" md="9" class="pr-1">
                <v-select
                    outlined
                    hide-details
                    label="หมวด"
                    :items="options"
                    item-key="id"
                    item-value="id"
                    @change="changeOption()"
                    v-model="option"
                    class="mb-2 pa-1"
                ></v-select>
            </v-col>
            <v-col cols="5" md="3" class="pl-1">
                <addOption
                    @emitSuccess="emitSuccess"
                    class="mt-1"
                    :propOption="option"
                    :propOptions="options"
                    :propMethod="'create'"
                ></addOption>
            </v-col>
        </v-row>

        <v-text-field
            outlined
            hide-details
            label="ค้นหา"
            v-model="search"
            class="mb-2 pa-1"
            :append-icon="search ? 'close' : ''"
            @click:append="() => (search = '')"
        ></v-text-field>
        <v-data-table
            :headers="headers()"
            :items="fetch_options"
            v-sortable-data-table
            @sorted="saveOrder"
            mobile-breakpoint="0"
            item-key="id"
            :items-per-page="999"
            hide-default-footer
            :search="search"
        >
            <template v-slot:item.manages="{ item }">
                <addOption
                    @emitSuccess="emitSuccess"
                    class="mt-1"
                    :propOption="option"
                    :propOptions="options"
                    :propMethod="'edit'"
                    :propText="item"
                ></addOption>
                <!-- <v-btn
                    icon
                    fab
                    x-small
                    class="warning"
                    @click="clickEdit(item)"
                >
                    <v-icon color="white">edit</v-icon>
                </v-btn> -->
            </template>
        </v-data-table>
    </div>
</template>

<script>
import Sortable from "sortablejs/modular/sortable.core.esm.js";
// import { mapGetters } from "vuex";
import addOption from "@/js/components/order/product/select/addOption";
export default {
    components: { addOption },
    data() {
        return {
            dialog: false,
            option: "",
            search: "",
            options: [
                { id: 1, text: "ประเภท" },
                { id: 2, text: "เนื้อเค้ก" },
                { id: 3, text: "ตกแต่ง" },
                { id: 4, text: "ขนาด" },
            ],
            fetch_options: [],
        };
    },
    methods: {
        headers() {
            return [
                {
                    text: "ลำดับ",
                    align: "start",
                    value: "sort",
                    width: "10%",
                },
                {
                    text: "ชื่อ",
                    value: `m${this.option}`,
                    width: "60%",
                },
                {
                    text: "การจัดการ",
                    align: "end",
                    value: "manages",
                    width: "30%",
                },
            ];
        },
        async changeOption() {
            let loader = this.$loading.show();
            const payload = {
                option_id: this.option,
            };
            const result = await this.$store.dispatch(
                `orderProductCake/fetch_options`,
                payload
            );

            this.fetch_options = result.options;
            loader.hide();
        },
        emitSuccess() {
            this.changeOption();
        },
        async clickEdit(v) {},
        exit() {
            this.$emit("emitLoadAgain");
            this.dialog = false;
        },
        async saveOrder(event) {
            let loader = this.$loading.show();

            const movedItem = await this.fetch_options.splice(
                event.oldIndex,
                1
            )[0];

            await this.fetch_options.splice(event.newIndex, 0, movedItem);

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
                this.fetch_options[i].sort = i + 1;
                data.push(this.fetch_options[i]);
            }

            const payload = {
                option: `a_m${this.option}`,
                sort: data,
            };

            await this.$store.dispatch(`orderProductCake/update_sort`, payload);

            loader.hide();
        },
    },
    computed: {
        // ...mapGetters({
        // }),
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
