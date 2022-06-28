<template>
    <div>
        <v-row>
            <v-col md="6"
                ><v-data-table
                    :headers="headers"
                    :items="desserts"
                    v-sortable-data-table
                    @sorted="saveOrder"
                    mobile-breakpoint="0"
                    item-key="id"
                    :items-per-page="999"
                    hide-default-footer
                ></v-data-table
            ></v-col>
            <v-col md="6"
                ><p v-for="d in desserts" :key="d.id">
                    {{ d.m4 }} {{ d.count }}
                </p></v-col
            >
        </v-row>

        {{ desserts }}
    </div>
</template>

<script>
import Sortable from "sortablejs";
export default {
    data() {
        return {
            headers: [
                // {
                //     text: "Dessert",
                //     align: "start",
                //     sortable: false,
                //     value: "name",
                // },
                {
                    text: "Dessert",
                    align: "start",
                    value: "m4",
                },
                {
                    text: "Dessert",
                    align: "end",
                    // sortable: true,
                    value: "count",
                },
            ],
            desserts: [],
            items: [],
        };
    },
    methods: {
        async start() {
            await axios
                .get(`/api/admin/v1/order/product/fetchOption`)
                .then((response) => {
                    // const data = ;
                    this.desserts = response.data.op4.sort((a, b) => a.count - b.count);

                });
        },
        async saveOrder(event) {
            let loader = this.$loading.show();
            const movedItem = await this.desserts.splice(event.oldIndex, 1)[0];
            await this.desserts.splice(event.newIndex, 0, movedItem);
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
                this.desserts[i].count = i + 1;
                data.push(this.desserts[i]);
            }
            const payload = {
                option: "a_m4",
                sort: data,
            };
            await axios.post(
                `/api/admin/v1/order/product/update_sort`,
                payload
            );
            loader.hide();
        },
    },
    mounted() {
        this.start();
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
