<template>
    <div>
        <v-dialog v-model="dialog" width="600" persistent>
            <template v-slot:activator="{ on }">
                <v-btn color="info" v-on="on" fab x-small @click="reload">
                    <v-icon>add</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    เพิ่มแท็กสินค้า
                    <v-spacer></v-spacer>
                    <v-btn color="success" fab x-small @click="save">
                        <v-icon>save</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-chip-group
                        v-model="form.product_category_sub_id"
                        column
                        multiple
                    >
                        <v-chip
                            filter
                            v-for="item in items"
                            :key="item.id"
                            :value="item.id"
                        >
                            {{ item.product_category.name }} - {{ item.name }}
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
export default {
    data() {
        return {
            asjdl: "",
            overlay: false,
            dialog: false,
            snackbar: {
                status: false
            },
            form: {
                product_id: this.data.id,
                product_category_sub_id: []
            },
            items: []
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
        async save() {
            this.overlay = true;
            await this.$store.dispatch("productTag/store", this.form);
            this.dialog = false;
            this.overlay = false;
        },
        async reload() {
            this.overlay = true;
            await this.$store.dispatch("productCategorySub/getUseOnly");
            this.items = this.$store.getters["productCategorySub/dataUseOnly"];
            await this.$store.dispatch(
                "productTag/isProductTags",
                this.form.product_id
            );
            this.form.product_category_sub_id = this.$store.getters[
                "productTag/isProductTags"
            ];
            this.overlay = false;
        }
    }
};
</script>

<style></style>
