<template>
    <div>
        <v-dialog width="400" v-model="dialog" scrollable persistent>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="info" v-if="propMethodCreate">
                    <v-icon left>add</v-icon>
                    เพิ่มคำตอบ
                </v-btn>
                <v-btn
                    v-on="on"
                    v-if="propMethodUpdate"
                    x-small
                    class="warning"
                    @click="clickStartUpdate()"
                >
                    แก้ไขคำตอบ
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white" dark>
                    {{ propMethodCreate ? "เพิ่มคำตอบ" : "" }}
                    {{ propMethodUpdate ? "แก้ไขคำตอบ" : "" }}
                    <v-spacer></v-spacer>
                    <v-btn fab x-small icon color="error" @click="clickExit()">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-textarea
                        class="mt-2"
                        outlined
                        hide-details
                        label="พิมพ์คำตอบ"
                        v-model="text"
                    ></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="error" @click="clickExit()">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                    <v-btn class="success" @click="clickSave()">
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
    props: ["propMethodCreate", "propMethodUpdate", "propReply"],
    data() {
        return {
            dialog: false,
            text: "",
        };
    },
    methods: {
        clickStartUpdate() {
            this.text = this.propReply.text_th;
        },
        async clickSave() {
            if (this.text == "") {
                this.$toast.warning("โปรดกรอกข้อมูลให้ครบถ้วน");
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                text: this.text,
                reply: this.propReply,
            };

            let result;
            if (this.propMethodCreate) {
                result = await this.$store.dispatch("facebook/store", payload);
            }

            if (this.propMethodUpdate) {
                result = await this.$store.dispatch("facebook/update", payload);
            }

            this.$store.dispatch("facebook/fetch");

            this.$swal({
                toast: true,
                timerProgressBar: true,
                timer: 3000,
                title: result.data.title,
                showConfirmButton: false,
                icon: result.data.icon,
                position: "bottom",
            });

            loader.hide();
            this.clickExit();
        },
        clickExit() {
            this.dialog = false;
            this.text = "";
        },
    },
};
</script>
