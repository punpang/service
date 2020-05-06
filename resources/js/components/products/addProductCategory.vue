<template>
    <div>
        <v-dialog v-model="dialog" width="600" persistent>
            <template v-slot:activator="{ on }">
                <v-btn color="info" v-on="on">เพิ่มกลุ่มสินค้า</v-btn>
            </template>
            <v-card>
                <v-card-title
                    >เพิ่มกลุ่มสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" lazy-validation>
                        <v-text-field
                            label="ชื่อกลุ่มสินค้า"
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

    </div>
</template>

<script>
export default {
    data() {
        return {
            overlay:false,
            dialog: false,
            loading: false,
            form: {
                name: "",
                status: true
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
                this.overlay = true;
                const response = await this.$store.dispatch(
                    "productCategory/add",
                    this.form
                );
                if (response.status === 200) {
                    this.dialog = false;
                    this.$toast.success("เพิ่มกลุ่มสินค้าสำเร็จ")
                    this.loading = false;
                    this.overlay = false;
                    this.form.status = true;
                    this.form.name = "";
                }
            } else {
                this.$toast.warning("คุณอาจกรอกไม่ครบหรือไม่ถูกต้อง")
            }
        },
        reset() {
            this.$toast.success("ล้างข้อมูลสำเร็จ")
            this.form.name = "";
        }
    }
};
</script>

<style></style>
