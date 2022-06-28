<template>
    <div>
        <v-dialog v-model="dialog" persistent scrollable width="400">
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    class="info"
                    @click="start()"
                    :disabled="propOption == ''"
                    x-large
                    block
                    v-if="propMethod == 'create'"
                >
                    <v-icon left> add </v-icon>
                    เพิ่ม
                </v-btn>

                <v-btn
                    v-else
                    v-on="on"
                    @click="start()"
                    icon
                    fab
                    x-small
                    class="warning"
                >
                    <v-icon color="white">edit</v-icon>
                </v-btn></template
            >
            <v-card>
                <v-card-title class="text-h5 white">
                    <v-icon left>
                        {{ propMethod == "create" ? "add" : "edit" }}
                    </v-icon>
                    {{
                        propMethod == "create" ? "เพิ่มข้อความ" : "แก้ไขข้อความ"
                    }}
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-2 pb-2">
                    <p class="text-h6 font-weight-bold mb-2">
                        หมวด :: {{ option.text }}
                    </p>

                    <v-text-field
                        outlined
                        hide-details
                        label="ข้อความ"
                        v-model="text"
                        class="mb-2 pa-1"
                        :append-icon="text ? 'close' : ''"
                        @click:append="() => (text = '')"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="success"
                        @click="save()"
                        :disabled="text == ''"
                    >
                        <v-icon left> save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["propOption", "propOptions", "propMethod", "propText"],
    data() {
        return {
            dialog: false,
            text: "",
            option: {},
        };
    },
    methods: {
        start() {
            this.option = this.propOptions.find((e) => {
                return e.id == this.propOption;
            });

            if (this.propMethod == "edit") {
                switch (this.propOption) {
                    case 1:
                        this.text = this.propText.m1;
                        break;
                    case 2:
                        this.text = this.propText.m2;
                        break;
                    case 3:
                        this.text = this.propText.m3;
                        break;
                    case 4:
                        this.text = this.propText.m4;
                        break;

                    default:
                        break;
                }
            }
        },
        async save() {
            if (this.option.id == "" || this.text == "") {
                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    icon: "warning",
                    title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                    timer: 3000,
                    timerProgressBar: true,
                    position: "bottom",
                });
                return;
            }
            let loader = this.$loading.show();
            let payload = {
                option_id: this.option.id,
                text: this.text,
            };

            switch (this.propMethod) {
                case "create":
                    await this.$store.dispatch(
                        "orderProductCake/add_option",
                        payload
                    );
                    break;

                case "edit":
                    payload.text_id = this.propText.id;
                    await this.$store.dispatch(
                        "orderProductCake/edit_option",
                        payload
                    );
                    break;

                default:
                    return;
                    break;
            }

            this.$swal({
                toast: true,
                allowOutsideClick: false,
                showConfirmButton: false,
                icon: "success",
                title: "สร้างสำเร็จ",
                timer: 3000,
                timerProgressBar: true,
                position: "bottom",
            });
            this.$emit("emitSuccess");
            this.exit();
            loader.hide();
        },

        exit() {
            this.dialog = false;
        },
    },
};
</script>
