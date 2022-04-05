<template>
    <div>
        <v-dialog persistent width="500" scrollable v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon color="error">priority_high</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    สร้างสินค้าเพิ่มเติม
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="py-2">
                    <v-text-field
                        readonly
                        v-model="propGoodsAddOn.name"
                        outlined
                        hide-details
                        label="ชื่อตัวเลือก"
                        class="mb-2"
                    ></v-text-field>
                    <v-text-field
                        v-model="price"
                        hide-details
                        outlined
                        label="ราคา"
                        suffix="บาท"
                        class="mb-2"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="success" @click="save()">
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["propAm4", "propGoodsAddOn"],
    data() {
        return {
            dialog: false,
            price: "",
        };
    },
    methods: {
        async save() {
            const payload = {
                m4: this.propAm4,
                goods_add_on: this.propGoodsAddOn,
                price: this.price,
            };

            await this.$store.dispatch(
                "orderIndex/createProductAddOn",
                payload
            );
            this.$emit("emitAutoUpdateAddOns")
            this.dialog = false;
        },
        exit() {
            this.dialog = false;
        },
    },
};
</script>
