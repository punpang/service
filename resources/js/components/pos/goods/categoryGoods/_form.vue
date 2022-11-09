<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                สร้างประเภท
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pt-5">
                <v-text-field
                    outlined
                    label="ชื่อประเภท"
                    hide-details
                    class="mb-3"
                    v-model="category_goods.text"
                ></v-text-field>
                <v-switch
                    outlined
                    label="สถานะใช้งาน"
                    hide-details
                    class="mb-3"
                    v-model="category_goods.status_use"
                ></v-switch>
            </v-card-text>
            <v-card-actions>
                <v-btn class="error" @click="exit()">
                    <v-icon left>exit_to_app</v-icon> ออก
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn class="orange" dark @click="clickSave()">
                    <v-icon left>save</v-icon>
                    บันทึก
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    props: ["propCategoryGoods"],
    data() {
        return {
            dialog: false,
            category_goods: {
                text: "",
                status_use: 1,
            },
        };
    },
    methods: {
        reset() {
            if (this.propCategoryGoods) {
                return;
            }
            this.category_goods = {
                text: "",
                status_use: 1,
            };
        },
        async clickSave() {
            if (
                this.category_goods.text == "" ||
                this.category_goods.status_use == "" ||
                (this.category_goods.id == "" && this.propCategoryGoods)
            ) {
                this.$swal({
                    toast: true,
                    title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                    icon: "warning",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    position: "bottom",
                });
                return;
            }
            let loader = this.$loading.show();
            const payload = this.category_goods;

            await this.$store
                .dispatch(
                    this.propCategoryGoods == undefined
                        ? "posCategoryGoods/store"
                        : "posCategoryGoods/update",
                    payload
                )
                .then((result) => {
                    // this.$emit("emitExit");
                    this.exit();
                    this.$swal({
                        toast: true,
                        title: result.data.title,
                        icon: result.data.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            loader.hide();
        },
        exit() {
            this.reset();
            this.$emit("emitExit");
        },
        setCategoryGoods() {
            this.category_goods = {
                id: this.propCategoryGoods.id,
                text: this.propCategoryGoods.text,
                status_use: this.propCategoryGoods.status_use,
            };
        },
    },
    mounted() {
        if (this.propCategoryGoods) {
            this.setCategoryGoods();
        }
    },
};
</script>

<style></style>
