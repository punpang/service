<template>
    <div>
        <v-row class="mt-1">
            <v-col cols="12" md="4">
                <v-text-field
                    v-model="search"
                    label="ค้นหา"
                    outlined
                    prepend-inner-icon="search"
                    hide-details
                    dense
                ></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-btn class="info" @click="clickSearch()">
                    <v-icon left>search</v-icon>
                    ค้นหาข้อมูล
                </v-btn>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :headers="headers"
            :items="orders"
            hide-default-footer
            mobile-breakpoint="0"
            :items-per-page="-1"
        >
            <template v-slot:item.id="{ item }">
                <v-btn class="deep-orange" dark @click="clickLink(item.id)">
                    {{ item.id }}
                </v-btn>
            </template>

            <template v-slot:item.customer="{ item }">
                <div class="d-flex flex-row justify-center">
                    {{ item.customer.name }} ( {{ item.customer.tel }} )
                </div>
            </template>

            <template v-slot:item.detail="{ item }">
                <strong
                    class="d-flex flex-row justify-end"
                    v-for="d in item.order_details"
                >
                    [ {{ d.message }} / {{ d.detail }} ]
                </strong>
            </template>
        </v-data-table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            orders: [],
            headers: [
                { text: "#", value: "id" },
                { text: "ชื่อและเบอร์โทร", value: "customer", align: "center" },
                { text: "ข้อความ/หมายเหตุ", value: "detail", align: "end" },
            ],
        };
    },
    methods: {
        async clickSearch() {
            window.location.href = `/manages/orders/search?search=${this.search}`;
        },
        clickLink(id) {
            // this.$loading.show();
            window.location.href = `/manages/order/${id}/showOrderByID`;
        },
    },
    async mounted() {
        if (this.$route.query.search) {
            let loader = this.$loading.show();
            this.search = await this.$route.query.search;
            const result = await axios.get(
                `/api/admin/v1/orders/fetch?search=${this.search}&with=orderDetails,customer&makeHidden=sum_all`
            );
            this.orders = await result.data;
            loader.hide();
        }
    },
};
</script>
