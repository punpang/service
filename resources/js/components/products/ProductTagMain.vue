<template>
    <div>
        <v-dialog v-model="dialog" width="600" persistent>
            <template v-slot:activator="{ on }">
                <v-btn color="blue-grey" v-on="on" fab x-small @click="reload">
                    <v-icon color="white">flag</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <v-icon>flag</v-icon>
                    {{ data.name }}
                    <v-spacer></v-spacer>
                    <ProductTagAdd :data="data" class="mr-2"></ProductTagAdd>
                    <v-btn color="error" @click="dialog = false" fab x-small>
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-chip-group column>
                        <v-chip
                            v-for="item in this.$store.getters[
                                'productTag/data'
                            ]"
                            :key="item.id"
                            >{{
                                item.product_category_sub.product_category.name
                            }}
                            - {{ item.product_category_sub.name }}
                        </v-chip>
                    </v-chip-group>
                </v-card-text>
            </v-card>
            <v-overlay :value="overlay">
                <v-progress-circular
                    indeterminate
                    :size="this.$store.getters['main/sizeOverlay']"
                ></v-progress-circular>
            </v-overlay>
        </v-dialog>
        <v-snackbar v-model="snackbar.status" :color="snackbar.color" right>{{
            snackbar.text
        }}</v-snackbar>
    </div>
</template>

<script>
import ProductTagAdd from "@/js/components/products/ProductTagAdd";
export default {
    components: {
        ProductTagAdd
    },
    data() {
        return {
            test: {},
            overlay: false,
            dialog: false,
            snackbar: {
                status: false
            },
            form: {
                product_id: this.data.id,
                product_category_sub_id: ""
            },
            product_tag: []
        };
    },
    props: ["data"],
    methods: {
        snackbarError() {
            this.snackbar = {
                status: true,
                text: "เกิดข้อผิดพลาดบางอย่าง ลองอีกครั้งภายหลัง",
                color: "error"
            };
        },
        async reload() {
            this.overlay = true;
            await this.$store.dispatch("productTag/get", this.form.product_id);
            this.overlay = false;
        },
        async clickProductCategorySub(item) {
            if (item) {
                this.overlay = true;
                this.loading = true;
                this.form.product_category_sub_id = item;
                //this.overlay = true;
                const response = await this.$store.dispatch(
                    "productTag/store",
                    this.form
                );
                if (response.status === 200) {
                    this.loading = false;
                    this.snackbar = {
                        status: true,
                        color: "success",
                        text: "เพิ่มสินค้าใหม่สำเร็จ"
                    };
                    this.overlay = false;
                }
            } else {
                this.snackbar = {
                    status: true,
                    color: "warning",
                    text: "คุณอาจกรอกไม่ครบหรือไม่ถูกต้อง"
                };
                this.overlay = false;
            }
        },
        reset() {
            this.snackbar = {
                status: true,
                color: "success",
                text: "ล้างข้อมูลสำเร็จ"
            };
            this.form.name = "";
        }
    }
};
</script>

<style></style>
