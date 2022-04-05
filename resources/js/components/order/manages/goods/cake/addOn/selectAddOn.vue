<template>
    <div>
        <v-row>
            <v-col cols="9" sm="10" md="10" class="pr-1">
                <v-text-field
                    label="ชื่อตัวเลือก"
                    outlined
                    v-model="search"
                    autofocus
                    hide-details
                ></v-text-field>
            </v-col>
            <v-col cols="3" sm="2" md="2" class="text-right pl-1">
                <v-btn fab outlined color="info" @click="clickSearch()">
                    <v-icon> refresh </v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-alert
            class="my-2"
            type="warning"
            dense
            v-if="propAm4 != fetchAddOn[0].am4_id"
        >
            โปรดรีเฟรซตัวเลือก
        </v-alert>
        <v-data-table
            :headers="headersFetchAddOn"
            :items="fetchAddOn"
            :search="search"
            hide-default-footer
        >
            <template v-slot:item.goods_add_on.name="{ item }">
                +{{ item.price }} {{ item.goods_add_on.name }}
            </template>
            <template v-slot:item.manages="{ item }">
                <div class="d-flex">
                    <v-spacer></v-spacer>
                    <btnEditProductAddOn
                        :propAddOn="item"
                        class="mr-1"
                    ></btnEditProductAddOn>

                    <v-btn
                        icon
                        fab
                        x-small
                        dark
                        class="info"
                        @click="clickSelect(item)"
                        :disabled="propAm4 != item.am4_id"
                    >
                        <v-icon>file_download</v-icon></v-btn
                    >
                </div>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnEditProductAddOn from "@/js/components/order/manages/goods/cake/addOn/btnEditProductAddOn";
export default {
    props: ["propAm4", "propAddOns", "propOrderDetail"],
    components: {
        btnEditProductAddOn,
    },
    data() {
        return {
            addOnName: "",
            dialog: false,
            search: "",
            headersFetchAddOn: [
                { text: "ชื่อตัวเลือก", value: "goods_add_on.name" },
                { text: "การจัดการ", value: "manages", align: "right" },
            ],
        };
    },
    methods: {
        async start() {
            await this.clickSearch();
        },
        async clickSearch() {
            let loader = this.$loading.show();
            const payload = {
                addOnName: this.addOnName,
                am4: this.propAm4,
            };
            // return;
            await this.$store.dispatch("orderProductCake/fetchAddOn", payload);

            loader.hide();
        },
        async clickSelect(v) {
            let loader = this.$loading.show();
            const payload = {
                add_on: v,
                order_detail_id: this.propOrderDetail.id,
                order_id: this.propOrderDetail.order_id,
            };
            await this.$store.dispatch("orderIndex/createAddOns", payload);
            this.$toast.success("เพิ่มเรียบร้อย");
            loader.hide();
        },
    },
    async mounted() {
        await this.start();
    },
    computed: {
        ...mapGetters({
            product: "orderProductCake/product",
            fetchAddOn: "orderProductCake/fetchAddOn",
        }),
    },
    // watch: {
    //     sumAddOn() {
    //         const sum = this.product.addOns.reduce((sum, { price }) => {
    //             return parseInt(sum + price);
    //         }, 0);
    //         this.sumAddOn = sum;
    //         console.log(sum);
    //         this.$store.commit("orderProductCake/sumAddOn");
    //     },
    // },
};
</script>
