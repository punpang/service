<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="orange" dark>
                    <v-icon left> add</v-icon>
                    สร้างประเภท
                </v-btn>
            </template>
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
                    <v-btn class="error">
                        <v-icon left>exit_to_app</v-icon> ออก
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="orange" dark @click="clickSave()">
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
        async clickSave() {
            // let loader = this.$loading.show();
            const payload = this.category_goods;
            await this.$store
                .dispatch("posCategoryGoods/store", payload)
                .then((result) => {
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
        },
        exit() {
            this.dialog = false;
        },
    },
};
</script>

<style></style>
