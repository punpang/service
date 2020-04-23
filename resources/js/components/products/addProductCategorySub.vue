<template>
    <div>
        <v-dialog v-model="dialog" width="600" persistent>
            <template v-slot:activator="{ on }">
                <v-btn color="info" v-on="on">เพิ่มกลุ่มสินค้าย่อย</v-btn>
            </template>
            <v-card>
                <v-card-title
                    >เพิ่มกลุ่มสินค้าย่อย
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" lazy-validation>
                        <v-select
                            v-model="form.product_category_id"
                            :items="
                                this.$store.getters[
                                    'productCategory/dataUseOnly'
                                ]
                            "
                            item-text="name"
                            item-value="id"
                            label="กลุ่มสินค้าใหญ่"
                            :rules="Rules.product_category_id"
                        >
                        </v-select>
                        <v-text-field
                            label="ชื่อกลุ่มสินค้าย่อย"
                            counter="100"
                            v-model="form.name"
                            :rules="Rules.name"
                        ></v-text-field>
                        <v-switch
                            inset
                            v-model="form.status"
                            label="สถานะ"
                        ></v-switch>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="success" @click="save" :loading="loading">
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                    <v-btn color="error" @click="reset">
                        <v-icon left>clear</v-icon>
                        ล้างข้อมูล
                    </v-btn>
                </v-card-actions>
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
            overlay: false,
            dialog: false,
            loading: false,
            form: {
                name: "",
                status: true,
                product_category_id: ""
            },
            Rules: {
                name: [
                    v => !!v || "ห้ามเว้นว่าง",
                    v => v.length <= 100 || "ไม่เกิน 100 ตัวอักษร"
                ],
                product_category_id: [v => !!v || "ห้ามเว้นว่าง"]
            },
            snackbar: {
                status: false
            }
        };
    },
    methods: {
        async save() {
            if (this.$refs.form.validate()) {
                this.loading = true;
                const response = await this.$store.dispatch(
                    "productCategorySub/add",
                    this.form
                );
                if (response.status === 200) {
                    this.dialog = false;
                    this.snackbar = {
                        status: true,
                        color: "success",
                        text: "เพิ่มกลุ่มสินค้าย่อยสำเร็จ"
                    };
                    this.form = {
                        name: "",
                        status: true,
                        product_category_id: ""
                    };
                    this.loading = false;
                } else if (response.status === 500) {
                    this.snackbar = {
                        status: true,
                        color: "warning",
                        text: "เกิดข้อผิดพลาดด้านเซิร์ฟเวอร์ กรุณาลองอีกครั้ง"
                    };
                    this.loading = false;
                } else {
                    this.snackbar = {
                        status: true,
                        color: "warning",
                        text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง"
                    };
                    this.loading = false;
                }
            } else {
                this.snackbar = {
                    status: true,
                    color: "warning",
                    text: "คุณอาจกรอกไม่ครบหรือไม่ถูกต้อง"
                };
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
