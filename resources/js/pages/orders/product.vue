<template>
    <div>
        <h4>สินค้า</h4>
        <v-container>
            <v-row>
                <MainProductCategory class="mr-2"></MainProductCategory>
                <ProductAdd
                class="mr-2"
                    :action="actionAdd"
                    :data="formDefault"
                ></ProductAdd>

                <ProductAddV2></ProductAddV2>
            </v-row>
        </v-container>

        <ProductGet></ProductGet>
    </div>
</template>

<script>
import MainProductCategory from "@/js/components/products/MainProductCategory";
import ProductAdd from "@/js/components/products/ProductAdd";
import ProductAddV2 from "@/js/components/products/ProductAddV2";
import ProductGet from "@/js/components/products/ProductGet";

export default {
    components: {
        MainProductCategory,
        ProductAdd,
        ProductGet,
        ProductAddV2
    },
    data() {
        return {
            actionAdd: "actionAdd",
            formDefault: {
                name: "",
                price_normal: "",
                price_special_status: true,
                price_special: "",
                status: "1",
                image_status: true,
                product_image_id: "1",
                product_image: {
                    src_name: ""
                }
            }
        };
    }
};
</script>

<style></style>
