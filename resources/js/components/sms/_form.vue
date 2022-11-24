<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                สร้างข้อความ
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="clickExit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="mt-4">
                <v-textarea
                    outlined
                    v-model="sms.message"
                    label="ข้อความ"
                    hide-details
                ></v-textarea>
            </v-card-text>
            <v-card-actions>
                <v-btn class="error">
                    <v-icon left>exit_to_app</v-icon>
                    ออก
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn class="success" dark @click="clickSave()">
                    <v-icon left>save</v-icon>
                    บันทึก
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    props: ["propMessage", "propUpdate"],
    data() {
        return {
            sms: {
                message: "",
            },
        };
    },
    methods: {
        resetForm() {
            this.sms = {
                message: "",
            };
        },
        clickExit() {
            if (!this.propUpdate) {
                this.resetForm();
            }

            this.$emit("emitExit");
        },
        async clickSave() {
            if (this.sms.message == "") {
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                sms: this.sms,
            };
            let dispatch = "";
            if (this.propUpdate) {
                dispatch = "smsMessages/update";
            } else {
                dispatch = "smsMessages/store";
            }

            await this.$store
                .dispatch(dispatch, payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        title: response.title,
                        icon: response.icon,
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });
                    this.clickExit();
                })
                .catch((error) => {
                    console.log(error);
                    this.$swal({
                        toast: true,
                        title: "เกิดข้อผิดพลาดบางอย่าง",
                        icon: "error",
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });
                });
            loader.hide();
        },
    },
    mounted() {
        if (this.propUpdate) {
            this.sms = this.propMessage;
        }
    },
};
</script>

<style></style>
