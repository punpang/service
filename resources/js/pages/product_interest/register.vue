<template>
    <div>
        <v-dialog persistent v-model="dialog" width="500">
            <template v-slot:activator="{ on }">
                <v-btn block class="info" x-large v-on="on">
                    <v-icon left>add</v-icon>
                    ลงทะเบียน
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    >ลงทะเบียน <v-spacer></v-spacer>
                    <v-btn icon x-small @click="clickExit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn></v-card-title
                >
                <v-card-text>
                    <v-form lazy-validation ref="formRegiter">
                        <v-text-field
                            label="เบอร์โทรศัพท์"
                            outlined
                            autofocus
                            pattern="\d*"
                            type="number"
                            :rules="rules.phone_number"
                            v-model="phone_number"
                        ></v-text-field>
                        <!-- <v-divider class="mt-0 mb-4"></v-divider> -->
                        <v-alert
                            type="warning"
                            dense
                            class="mb-0"
                            v-if="goods.length == 0"
                            >โปรดเลือกสินค้า</v-alert
                        >

                        <v-card
                            class="mb-2"
                            v-for="item in goods"
                            :key="item.id"
                            outlined
                        >
                            <v-card-title>
                                <p class="mb-0 text-body-2">{{ item.text }}</p>
                                <v-spacer></v-spacer>
                                <v-btn
                                    fab
                                    icon
                                    x-small
                                    @click="remove_goods(item)"
                                >
                                    <v-icon color="error">delete</v-icon>
                                </v-btn>
                            </v-card-title>
                        </v-card>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <btnRegister
                        @emitAddGoodsProductInterest="
                            emitAddGoodsProductInterest
                        "
                    ></btnRegister>
                    <v-spacer></v-spacer>
                    <v-btn class="error" @click="clickReset">
                        <v-icon left>delete</v-icon>
                        ล้าง
                    </v-btn>
                    <v-btn
                        class="success"
                        :disabled="goods.length == 0"
                        @click="clickSave()"
                    >
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import btnRegister from "@/js/pages/product_interest/btnRegister.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        btnRegister,
    },
    data() {
        return {
            goods: [],
            phone_number: "0",
        };
    },
    methods: {
        clickExit() {
            this.dialog = false;
            this.phone_number = "0";
            this.goods = [];
        },
        async clickSave() {
            if (!this.goods || !this.$refs.formRegiter.validate()) {
                this.$swal({
                    title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                    toast: true,
                    icon: "warning",
                    showConfirmButton: false,
                    position: "bottom",
                    timer: "3000",
                    timerProgressBar: true,
                });
                return;
            }

            let loader = this.$loading.show();

            const payload = {
                goods: this.goods,
                phone_number: this.phone_number,
            };

            await axios
                .post(`/api/admin/v1/product_interest/store`, payload)
                .then((response) => {
                    this.$swal({
                        title: response.data.title,
                        toast: true,
                        icon: response.data.icon,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: "3000",
                        timerProgressBar: true,
                    });
                    this.clickExit();
                })
                .catch((error) => {
                    this.$swal({
                        title: "เกิดข้อผิดพลาดบางประการ",
                        toast: true,
                        icon: "error",
                        showConfirmButton: false,
                        position: "bottom",
                        timer: "3000",
                        timerProgressBar: true,
                    });
                });

            this.$emit("emitFetch");
            loader.hide();
            return;
        },
        clickReset() {
            this.goods = [];
            this.phone_number = "";
        },
        remove_goods(v) {
            const findIndex = this.goods.findIndex((e) => {
                return e == v;
            });
            this.goods.splice(findIndex, 1);
        },
        emitAddGoodsProductInterest(propGoods) {
            const find = this.goods.find((e) => {
                return e.id == propGoods.id;
            });

            if (find) {
                this.$swal({
                    title: "มีรายการนี้อยู่แล้ว !",
                    toast: true,
                    icon: "warning",
                    showConfirmButton: false,
                    position: "bottom",
                    timer: "3000",
                    timerProgressBar: true,
                });
            } else {
                this.goods.push(propGoods);
                this.$swal({
                    title: `เพิ่ม "${propGoods.text}" แล้ว`,
                    toast: true,
                    icon: "success",
                    showConfirmButton: false,
                    position: "bottom",
                    timer: "3000",
                    timerProgressBar: true,
                });
            }
        },
    },
    computed: {
        ...mapGetters({
            rules: "orderCustomer/rules",
        }),
    },
};
</script>

<style></style>
