<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                {{
                    propLinkRawMaterial == null
                        ? "ผูกวัตถุดิบ"
                        : "แก้ไขผูกวัตถุดิบ"
                }}
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pt-5">
                ชื่อสินค้า : {{ propGoods.text }}
                <v-divider></v-divider>
                ชื่อวัตถุดิบ : {{ propRawMaterial.text }} (฿{{
                    propRawMaterial.price
                }}
                : {{ propRawMaterial.weight }})

                <v-divider></v-divider>

                <v-text-field
                    outlined
                    label="น้ำหนัก/ปริมาณ"
                    hide-details
                    class="mb-3"
                    pattern="\d*"
                    type="number"
                    v-model="link_raw_material.weight"
                ></v-text-field>
                # 1 กิโลกรัม = 1,000 กรัม # 1 ลิตร = 1,000 มิลลิลิตร
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
    props: ["propRawMaterial", "propGoods", "propLinkRawMaterial"],
    data() {
        return {
            dialog: false,
            link_raw_material: {
                raw_material_id: "",
                goods_id: "",
                weight: "",
                text: "",
                price: "",
            },
        };
    },
    methods: {
        reset() {
            if (this.propRawMaterial) {
                return;
            }
            this.link_raw_material = {
                raw_material_id: "",
                goods_id: "",
                weight: "",
                text: "",
                price: "",
            };
        },
        async clickSave() {
            if (
                this.link_raw_material.raw_material_id == "" ||
                this.link_raw_material.goods_id == "" ||
                this.link_raw_material.weight == ""
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
            const payload = this.link_raw_material;

            await this.$store
                .dispatch(
                    this.propLinkRawMaterial == undefined
                        ? "posLinkRawMaterial/store"
                        : "posLinkRawMaterial/update",
                    payload
                )
                .then((result) => {
                    // this.$emit("emitFetchGoods");
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
            this.$emit("emitFetchGoods");
        },
        setLinkRawMaterial() {
            if (this.propLinkRawMaterial == null) {
                this.link_raw_material = {
                    pos_raw_material_id: this.propRawMaterial.id,
                    pos_goods_id: this.propGoods.id,
                    weight: "",
                };
            } else {
                this.link_raw_material = {
                    id: this.propLinkRawMaterial.id,
                    pos_raw_material_id:
                        this.propLinkRawMaterial.pos_raw_material_id,
                    pos_goods_id: this.propLinkRawMaterial.pos_goods_id,
                    weight: this.propLinkRawMaterial.weight,
                };
            }
        },
    },
    mounted() {
        this.setLinkRawMaterial();
        // if (this.propLinkRawMaterial) {

        // }
    },
};
</script>

<style></style>
