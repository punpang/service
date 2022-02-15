<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" icon fab small dark elevation="0" class="info">
                    <v-icon> add </v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ตัวเลือกเพิ่มเติม
                    <v-spacer></v-spacer>
                    <v-btn
                        icon
                        fab
                        x-small
                        class="white"
                        @click="dialog = false"
                    >
                        <v-icon color="warning"> close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-4">
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
                            <v-btn
                                fab
                                outlined
                                color="info"
                                @click="clickSearch()"
                            >
                                <v-icon> search </v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-simple-table>
                        <tbody>
                            <tr v-for="addOn in fetchAddOn" :key="addOn.id">
                                <td>
                                    {{ addOn.goods_add_on.name }}
                                    {{ addOn.price }} บาท
                                </td>
                                <td class="text-right">
                                    <v-btn
                                        icon
                                        fab
                                        x-small
                                        dark
                                        class="warning"
                                    >
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
                </v-card-text>
            </v-card>
        </v-dialog>
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
        };
    },
    methods: {
        async clickSearch() {
            let loader = this.$loading.show();
            const payload = {
                addOnName: this.addOnName,
                am4: this.product.data.m4,
            };

            await this.$store.dispatch("orderProductCake/fetchAddOn", payload);

            loader.hide();
        },
        async clickSelect(v) {
            await this.$store.commit("orderProductCake/addProductAddOn", v);
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
