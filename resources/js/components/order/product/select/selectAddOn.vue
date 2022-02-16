<template>
    <div>
        <v-row>
            <v-col cols="9" md="10" class="pr-1">
                <!-- <v-text-field
                    label="ชื่อตัวเลือก"
                    outlined
                    v-model="addOnName"
                    autofocus
                ></v-text-field>
                {{ value_addOns }} -->
                <v-autocomplete
                    v-model="value_addOns"
                    :items="fetchAddOn"
                    outlined
                    chips
                    item-text="goods_add_on.name"
                    item-value="id"
                    clearable
                    deletable-chips
                    small-chips
                    multiple
                    label="ตัวเลือก"
                    hide-details
                    @change="changeAddOns()"
                >
                    <template v-slot:selection="data">
                        <v-chip close @click:close="remove(data.item)">
                            +{{ data.item.price }}
                            {{ data.item.goods_add_on.name }}
                        </v-chip>
                    </template>

                    <template v-slot:item="data">
                        <template>
                            <v-list-item-content>
                                <v-list-item-title
                                    v-html="data.item.goods_add_on.name"
                                ></v-list-item-title>
                                <v-list-item-subtitle
                                    v-html="`+ ${data.item.price} บาท`"
                                ></v-list-item-subtitle>
                            </v-list-item-content>
                        </template>
                    </template>
                </v-autocomplete>
            </v-col>
            <v-col cols="3" md="2" class="text-right pl-1">
                <v-btn fab outlined color="info" @click="clickSearch()">
                    <v-icon> search </v-icon>
                </v-btn>
            </v-col>
        </v-row>

        <!-- <v-simple-table>
            <tbody>
                <tr v-for="addOn in fetchAddOn" :key="addOn.id">
                    <td class="px-1">
                        {{ addOn.goods_add_on.name }}
                        {{ addOn.price }} บาท
                    </td>
                    <td class="text-right px-1" width="30%">
                        <v-btn icon fab x-small dark class="warning">
                            <v-icon>edit</v-icon></v-btn
                        >

                        <v-btn
                            icon
                            fab
                            x-small
                            dark
                            class="info"
                            @click="clickSelect(addOn)"
                        >
                            <v-icon>file_download</v-icon></v-btn
                        >
                    </td>
                </tr>
            </tbody>
        </v-simple-table> -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propAm4", "propAddOns"],
    data() {
        return {
            addOnName: "",
            dialog: false,
            value_addOns: [],
        };
    },
    methods: {
        async start() {
            await this.clickSearch();
            await this.getValueAddOns();
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
        clickSelect(v) {
            this.$emit("emitPushAddOn", v);
        },
        changeAddOns() {
            let selected = [];
            this.value_addOns.forEach((v) => {
                selected.push(
                    this.fetchAddOn.find((d) => {
                        return d.id == v;
                    })
                );
            });
            this.$emit("emitPushAddOn", selected);
        },
        getValueAddOns() {
            let goods_add_on_id = [];
            this.propAddOns.forEach((v) => {
                goods_add_on_id.push(v.id);
            });
            this.value_addOns = goods_add_on_id;
        },
        remove(item) {
            const index = this.value_addOns.indexOf(item.id);
            if (index >= 0) this.value_addOns.splice(index, 1);
            this.changeAddOns();
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
