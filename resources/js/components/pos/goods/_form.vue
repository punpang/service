<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                {{ propGoods ? "แก้ไขสินค้า" : "สร้างสินค้า" }}
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pt-5">
                <v-text-field
                    outlined
                    label="ชื่อสินค้า"
                    hide-details
                    class="mb-3"
                    v-model="goods.text"
                ></v-text-field>
                <v-text-field
                    pattern="\d*"
                    type="number"
                    outlined
                    label="ราคา"
                    hide-details
                    class="mb-3"
                    suffix="บาท"
                    v-model="goods.price"
                ></v-text-field>
                <v-select
                    outlined
                    label="ประเภท"
                    hide-details
                    class="mb-3"
                    :items="category_goods"
                    item-text="text"
                    item-value="id"
                    v-model="goods.pos_category_goods_id"
                ></v-select>
                <v-switch
                    outlined
                    label="สถานะใช้งาน"
                    hide-details
                    class="mb-3"
                    v-model="goods.status_use"
                ></v-switch>
                <!-- <v-btn text block large class="error--text" v-if="propGoods">
                    <v-icon left>delete</v-icon> ลบรายการนี้
                </v-btn> -->
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
import { mapGetters } from "vuex";
export default {
    props: ["propGoods"],
    data() {
        return {
            dialog: false,
            goods: {
                text: "",
                price: "",
                status_use: 1,
                pos_category_goods_id: "",
            },
        };
    },
    methods: {
        reset() {
            this.goods = {
                text: "",
                price: "",
                status_use: 1,
                pos_category_goods_id: "",
            };
        },
        async clickSave() {
            if (
                this.goods.text == "" ||
                this.goods.price == "" ||
                this.goods.pos_category_goods_id == "" ||
                this.goods.status_use == null ||
                (this.goods.id == "" && this.propGoods)
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
            const payload = this.goods;
            await this.$store
                .dispatch(
                    this.propGoods == undefined
                        ? "posGoods/store"
                        : "posGoods/update",
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
            if (!this.propGoods) {
                this.reset();
            }
            this.$emit("emitExit");
        },
        clickStart() {
            this.fetch_category_goods();
        },
        setGoods() {
            this.goods = {
                id: this.propGoods.id,
                text: this.propGoods.text,
                price: this.propGoods.price,
                status_use: this.propGoods.status_use,
                pos_category_goods_id: this.propGoods.pos_category_goods_id,
            };
        },

        async fetch_category_goods() {
            let loader = this.$loading.show();
            await this.$store
                .dispatch("posCategoryGoods/fetch")
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
            loader.hide();
        },
    },
    async mounted() {
        if (this.propGoods) {
            await this.setGoods();
        }
        await this.fetch_category_goods();
    },

    computed: {
        ...mapGetters({
            category_goods: "posCategoryGoods/fetch",
        }),
    },
};
</script>
