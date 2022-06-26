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
                >
                    <v-icon left> add </v-icon>
                    เพิ่ม
                </v-btn></template
            >
            <v-card>
                <v-card-title class="text-h5 white">
                    <v-icon left>add</v-icon>
                    เพิ่มข้อความ
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
                    <v-btn class="success" @click="save()">
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
    props: ["propOption", "propOptions"],
    methods: {
        start() {
            this.option = this.propOptions.find((e) => {
                return e.id == this.propOption;
            });
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
            const payload = {
                option_id: this.option.id,
                text: this.text,
            };

            await this.$store.dispatch("orderProductCake/add_option", payload);
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
    data() {
        return {
            dialog: false,
            text: "",
            option: {},
        };
    },
};
</script>
