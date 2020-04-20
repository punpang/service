<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
            <template v-slot:activator="{ on }">
                <v-btn block color="primary" v-on="on" class="mb-2"
                    >เพิ่มสินค้าใหม่</v-btn
                >
            </template>
            <v-card color="#121212">
                <v-card-title>
                    เพิ่มสินค้าใหม่
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <selectProduct
                        @emitSelectProduct="emitSelectProduct"
                    ></selectProduct>
                    <v-card v-show="selected == true">
                        <v-card-text class="py-0">
                            <v-row>
                                <v-col cols="12" md="3"
                                    ><v-img
                                        width="auto"
                                        :src="
                                            'https://drive.google.com/thumbnail?id=' +
                                                product.product_image.src_name
                                        "
                                    ></v-img
                                ></v-col>
                                <v-col cols="12" md="9">
                                    <div class="title">
                                        {{ product.name }}
                                    </div>
                                    <div class="subtitle-1">
                                        <priceProduct
                                            :price="product"
                                        ></priceProduct>
                                    </div>
                                    <div
                                        v-for="tag in product.product_tag_use_only"
                                        :key="tag.id"
                                    >
                                        <tagsProduct :tag="tag"></tagsProduct>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                    <v-card>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-text-field
                                        label="เขียนข้อความ"
                                        :readonly="form.write_status == false"
                                    ></v-text-field>
                                    <v-switch
                                        v-model="form.write_status"
                                        inset
                                        hide-details
                                        class="ml-4"                                        
                                        @change="changeWriteStatus"
                                    ></v-switch>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import selectProduct from "@/js/components/orders/details/selectProduct";
import tagsProduct from "@/js/components/orders/details/tagsProduct";
import priceProduct from "@/js/components/orders/details/priceProduct";

export default {
    props: ["order"],
    components: {
        selectProduct,
        tagsProduct,
        priceProduct
    },
    data() {
        return {
            dialog: false,
            selected: false,
            product: {
                product_image: {
                    src_name: ""
                },
                price_normal: 0,
                price_special_status: 0,
                price_special: 0
            },
            priceProduct: 0,
            form: {
                write_status: 1
            }
        };
    },
    methods: {
        emitSelectProduct(item) {
            this.product = item;
            this.selected = true;
        },
        changeWriteStatus(value)
        {
                        
        }
    }
};
</script>

<style></style>
