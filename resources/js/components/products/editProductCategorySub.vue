<template>
    <div>
        <v-dialog v-model="dialog" width="600" persistent>
            <template v-slot:activator="{ on }">
                <v-icon color="warning" v-on="on" class="d-flex d-sm-none"
                    >edit</v-icon
                >
                <v-btn
                    color="warning"
                    small
                    v-on="on"
                    rounded
                    class="d-none d-sm-flex"
                    ><v-icon left small>edit</v-icon>แก้ไข</v-btn
                >
            </template>
            <v-card>
                <v-card-title
                    >แก้ไขกลุ่มสินค้าย่อย
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
                            required
                        ></v-select>
                        <v-text-field
                            label="ชื่อกลุ่มสินค้าย่อย"
                            counter="100"
                            v-model="form.name"
                            :rules="Rules.name"
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="success" @click="save" :loading="loading">
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                    <v-btn color="error" @click="dialog = false">
                        <v-icon left>close</v-icon>
                        ปิด
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
    </div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            overlay: false,
            loading: false,
            dialog: false,
            form: {
                id: this.data.id,
                name: this.data.name,
                product_category_id: this.data.product_category_id
            },
            Rules: {
                name: [
                    v => !!v || "ห้ามเว้นว่าง",
                    v => v.length <= 100 || "ไม่เกิน 100 ตัวอักษร"
                ]
            },
        };
    },
    methods: {
        async save() {
            if (this.$refs.form.validate()) {
                this.loading = true;
                const response = await this.$store.dispatch(
                    "productCategorySub/update",
                    this.form
                );
                if (response.status === 200) {
                    this.$toast.success("แก้ไขกลุ่มสินค้าย่อยสำเร็จ")
                    this.loading = false;
                    this.dialog = false;
                }
            } else {
                this.$toast.warning("คุณอาจกรอกไม่ครบหรือไม่ถูกต้อง")
            }
        }
    }
};
</script>

<style></style>
