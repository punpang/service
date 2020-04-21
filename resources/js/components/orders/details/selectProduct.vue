<template>
    <v-dialog v-model="dialog" persistent width="700">
        <template v-slot:activator="{ on }">
            <v-btn color="primary" v-on="on" block large>
                <v-icon left>fiber_new</v-icon>
                เลือกสินค้า
            </v-btn>
        </template>
        <v-card color="#121212">
            <v-card-title>
                รายการสินค้า
                <v-spacer></v-spacer>
                <v-icon color="error" @click="dialog = false">close</v-icon>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="search"
                    label="ค้นหาสินค้า"
                    append-icon="search"
                ></v-text-field>
                <v-data-table
                    :items="this.$store.getters['product/dataUseOnly']"
                    item-key="id"
                    :headers="headers"
                    :search="search"
                >
                    <template v-slot:item.image="{ item }">
                        <v-img
                            v-show="item.image_status == true"
                            width="100"
                            :src="
                                'https://drive.google.com/thumbnail?id=' +
                                    item.product_image.src_name
                            "
                        ></v-img>
                    </template>
                    <template v-slot:item.price="{ item }">
                        <span v-if="item.price_special_status == 0"
                            >{{ item.price_normal }}.00</span
                        >
                        <span v-else>{{ item.price_special }}.00</span>
                    </template>
                    <template v-slot:item.tags="{ item }">
                        <div v-for="tag in item.product_tag_use_only" :key="tag.id">
                            <tagsProduct :tag="tag"></tagsProduct>
                        </div>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-btn
                            @click="clickSelectProduct(item)"
                            color="info"
                            small
                        >
                            เลือก
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import tagsProduct from "@/js/components/orders/details/tagsProduct";
export default {
    components:{
        tagsProduct
    },
    data() {
        return {
            dialog: false,
            search: "",
            headers: [
                { text: "รูปภาพ", value: "image", align: "center" },
                { text: "ชื่อสินค้า", value: "name", align: "center" },
                { text: "ราคา", value: "price", align: "center" },
                { text: "แท็กสินค้า", value: "tags", align: "center" },
                { text: "การจัดการ", value: "action", align: "end" }
            ]
        };
    },
    methods: {
        clickSelectProduct(item) {
            this.$emit("emitSelectProduct", item);
            this.dialog = false;
        }
    },
    async beforeCreate() {
        await this.$store.dispatch("product/getUseOnly");
        this.loadingTable = false;
        this.overlay = false;
    }
};
</script>

<style></style>
