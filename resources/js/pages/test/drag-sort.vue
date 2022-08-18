<template>
    <div>
        <!-- <v-row>
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

        {{ desserts }} -->
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
                    this.desserts = response.data.op4.sort(
                        (a, b) => a.count - b.count
                    );
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
        // this.start();
        const mp = [
            { m: 15, p: 0 },
            { m: 60, p: 10 },
            { m: 120, p: 10 },
            { m: 180, p: 10 },
            { m: 240, p: 20 },
            { m: 300, p: 20 },
            { m: 360, p: 20 },
            { m: 361, p: 110 },
        ];
        //         const mp = [
        //     { m: 15, p: 0 },
        //     { m: 60, p: 10 },
        //     { m: 120, p: 20 },
        //     { m: 180, p: 30 },
        //     { m: 240, p: 50 },
        //     { m: 300, p: 70 },
        //     { m: 360, p: 90 },
        //     { m: 361, p: 200 },
        // ];
        const input = [
            [8,32,11,32]
        ];

        for (let i = 0; i < input.length; i++) {
            // const h = (input[i][2] - input[i][0]) * 60;
            // const m = input[i][3] - input[i][1];
            // const t = h + m;
            const t =
                (input[i][2] - input[i][0]) * 60 + input[i][3] - input[i][1];

            const a =
                t % 60 == 0 ? t : t <= mp[0].m ? t : Math.ceil(t / 60) * 60;

            const r = mp.reduce((sum, n) => {
                return n.m <= a ? sum + n.p : sum;
            }, 0);

            console.log("🚀 ~ file: drag-sort.vue ~ line 142 ~ s ~ s", r);
        }
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
