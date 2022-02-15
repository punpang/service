<template>
    <div>
        <v-row>
            <v-col cols="9" md="9" class="pr-1">
                <v-text-field
                    label="ชื่อตัวเลือก"
                    outlined
                    v-model="addOnName"
                    autofocus
                ></v-text-field>
            </v-col>
            <v-col cols="3" md="3" class="text-right pl-1">
                <v-btn fab outlined color="info" @click="clickSearch()">
                    <v-icon> search </v-icon>
                </v-btn>
            </v-col>
        </v-row>
        {{ values }}
        <v-autocomplete
            v-model="values"
            :items="fetchAddOn"
            outlined
            chips
            item-text="goods_add_on.name"
            item-value="id"
            clearable
            deletable-chips
            small-chips
            multiple
        ></v-autocomplete>

        <v-simple-table>
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
        </v-simple-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propAm4"],
    data() {
        return {
            addOnName: "",
            dialog: false,
            values: [],
        };
    },
    methods: {
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
