<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                {{
                    propRawMaterial == null ? "สร้างวัตถุดิบ" : "แก้ไขวัตถุดิบ"
                }}
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pt-5">
                <v-text-field
                    outlined
                    label="ชื่อวัตถุดิบ"
                    hide-details
                    class="mb-3"
                    v-model="raw_material.text"
                ></v-text-field>
                <v-text-field
                    outlined
                    label="ราคา"
                    hide-details
                    class="mb-3"
                    v-model="raw_material.price"
                    suffix="บาท"
                    pattern="\d*"
                    type="number"
                ></v-text-field>
                <v-text-field
                    outlined
                    label="น้ำหนัก/ปริมาณ"
                    hide-details
                    class="mb-3"
                    pattern="\d*"
                    type="number"
                    v-model="raw_material.weight"
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
    props: ["propRawMaterial"],
    data() {
        return {
            dialog: false,
            raw_material: {
                text: "",
                price: "",
                weight: "",
            },
        };
    },
    methods: {
        reset() {
            if (this.propRawMaterial) {
                return;
            }
            this.raw_material = {
                text: "",
                price: "",
                weight: "",
            };
        },
        async clickSave() {
            if (
                this.raw_material.text == "" ||
                this.raw_material.price == "" ||
                this.raw_material.weight == ""
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
            // let loader = this.$loading.show();
            const payload = this.raw_material;

            await this.$store
                .dispatch(
                    this.propRawMaterial == undefined
                        ? "posRawMaterial/store"
                        : "posRawMaterial/update",
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
            // loader.hide();
        },
        exit() {
            this.reset();
            this.$emit("emitExit");
        },
        setRawMaterial() {
            this.raw_material = {
                id: this.propRawMaterial.id,
                text: this.propRawMaterial.text,
                price: this.propRawMaterial.price,
                weight: this.propRawMaterial.weight,
            };
        },
    },
    mounted() {
        if (this.propRawMaterial) {
            this.setRawMaterial();
        }
    },
};
</script>

<style></style>
