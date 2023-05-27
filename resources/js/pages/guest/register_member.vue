<template>
    <div>
        <v-card v-if="showFormRegister" class="mt-5" outlined>
            <v-card-title>
                <v-icon left>face</v-icon>
                {{ is_member ? "สมาชิก" : "สมัครสมาชิก" }}
            </v-card-title>
            <v-card-text class="pt-5 pb-10">
                <v-row justify="center">
                    <v-col cols="10" md="4">
                        <v-text-field
                            label="ชื่อลูกค้า"
                            outlined
                            hide-details
                            v-model="name"
                            class="mb-3"
                            append-icon="account_circle"
                        ></v-text-field>

                        <v-text-field
                            label="เบอร์โทรศัพท์"
                            outlined
                            hide-details
                            v-model="phone"
                            append-icon="phone"
                            class="mb-3"
                            type="number"
                            pattern="\d*"
                        ></v-text-field>

                        <v-btn
                            color="success"
                            @click="register"
                            block
                            large
                            :loading="loading"
                        >
                            <v-icon left>
                                {{ is_member ? "save" : "person_add" }}
                            </v-icon>
                            {{
                                is_member ? "บันทึกข้อมูล" : "สมัครสมาชิก"
                            }}</v-btn
                        >
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: {
                query: "",
            },
            name: "",
            phone: "",
            is_member: false,
            showFormRegister: false,
        };
    },
    methods: {
        async check_expires() {
            let loader = this.$loading.show();
            await axios
                .post(
                    `/api/v1/guest/register_member_by_facebook?${this.url.query}`,
                    {
                        check_expires: true,
                    }
                )
                .then((response) => {
                    this.showFormRegister = true;
                    if (response.data.customer_id != null) {
                        const customer = response.data.customer;
                        this.name = customer.name;
                        this.phone = customer.tel;
                        this.is_member = true;
                    }
                })
                .catch((err) => {
                    this.$swal({
                        icon: "error",
                        title: "ลิงก์หมดอายุ",
                        text: "โปรดทำรายการใหม่",
                        showConfirmButton: false,
                        allowOutsideClick:false
                    });
                });

            loader.hide();
        },

        async register() {
            if (this.name == "" || this.phone == "") {
                this.$toast.error("โปรดกรอกช่องชื่อลูกค้าและเบอร์โทรศัพท์ให้ครบถ้วน")
                return;
            }
            let loader = this.$loading.show();
            await axios
                .post(
                    `/api/v1/guest/register_member_by_facebook?${this.url.query}`,
                    {
                        name: this.name,
                        phone: this.phone,
                    }
                )
                .then((response) => {
                    if (response.data.status == "success") {
                        this.$swal({
                            icon: response.data.icon,
                            title: response.data.title,
                            text: response.data.text,
                            showConfirmButton: false,
                            allowOutsideClick:false
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

            loader.hide();
        },
    },
    async mounted() {
        // console.log(this.$route);
        // console.log(this.$route.fullPath);
        const fullPathSplit = this.$route.fullPath.split("?");
        this.url.query = fullPathSplit[1];
        await this.check_expires();
    },
};
</script>

<style></style>
