<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    class="cyan d-none d-sm-flex"
                    :small="propSmall"
                    dark
                    @click="clickStart()"
                >
                    <v-icon left> send</v-icon>
                    ส่งข้อความ
                </v-btn>

                <v-btn
                    icon
                    fab
                    small
                    v-on="on"
                    class="cyan d-flex d-sm-none"
                    dark
                    @click="clickStart()"
                >
                    <v-icon> send</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ส่งข้อความ
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="clickExit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-4">
                    <v-form ref="form" lazy-validation>
                        <v-text-field
                            outlined
                            label="เบอร์โทรศัพท์"
                            prepend-inner-icon="phone"
                            type="number"
                            pattern="\d*"
                            :rules="rules.phone_number"
                            v-model="sms.phone_number"
                            hide-details
                            class="mb-3"
                        ></v-text-field>

                        <v-textarea
                            outlined
                            v-model="sms.message"
                            label="ข้อความ"
                            prepend-inner-icon="comment"
                            hide-details
                        ></v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn class="error" @click="clickExit()">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="success" dark @click="clickSend()">
                        <v-icon left>send</v-icon>
                        ส่งข้อความ
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propSmall", "propMessage"],
    data() {
        return {
            dialog: false,
            sms: {
                id:"",
                phone_number: "",
                message: "",
            },
        };
    },
    methods: {
        clickStart() {
            if (this.propMessage) {
                this.sms.id = this.propMessage.id
                this.sms.message = this.propMessage.message;
            }
        },
        clickExit() {
            this.dialog = false;
        },
        async clickSend() {
            if (!this.$refs.form.validate() || this.sms.message == "") {
                return;
            }
            let loader = this.$loading.show();
            const payload = {
                sms: this.sms,
            };
            await this.$store
                .dispatch("smsMessages/send", payload)
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
                    this.sms.phone_number = "";
                    this.dialog = false;
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
    computed: {
        ...mapGetters({
            rules: "orderCustomer/rules",
        }),
    },
};
</script>

<style></style>
