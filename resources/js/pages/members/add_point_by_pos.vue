<template>
    <div>
        <!-- <v-toolbar flat>
            <v-toolbar-title></v-toolbar-title>
        </v-toolbar> -->

        <v-card>
            <v-card-title> เพิ่มคะแนนสะสม </v-card-title>
            <v-card-text class="mt-5">
                <v-form lazy-validation ref="form">
                    <v-row class="d-flex justify-center">
                        <v-col cols="10" md="5" class="pt-0 pb-0">
                            <v-text-field
                                label="เบอร์โทรศัพท์"
                                outlined
                                pattern="\d*"
                                type="number"
                                v-model="form.phone"
                                :rules="rules.phone_number"
                                append-icon="phone"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row class="d-flex justify-center">
                        <v-col cols="10" md="5" class="pt-0 pb-0">
                            <v-text-field
                                label="ยอดซื้อ"
                                outlined
                                pattern="\d*"
                                type="number"
                                v-model="form.amount"
                                :rules="ruleName"
                                append-icon="attach_money"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row class="d-flex justify-center">
                        <v-col cols="12" md="5" class="text-right pt-0">
                            <v-btn class="error mr-6" @click="clickReset()">
                                <v-icon left>delete</v-icon>
                                ล้าง</v-btn
                            >
                            <v-btn class="warning" @click="clickSave()">
                                <v-icon left>save</v-icon>
                                บันทึก</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            form: {
                phone: "",
                amount: "",
            },
            ruleName: [(v) => !!v || "ห้ามเว้นว่าง"],
        };
    },
    methods: {
        clickReset() {
            this.form = { phone: "", amount: "" };
        },
        async clickSave() {
            if (this.$refs.form.validate()) {
                let loader = this.$loading.show();
                const payload = this.form;
                const results = await axios
                    .post(
                        "/api/admin/v1/customer_score/add_point_by_pos",
                        payload
                    )
                    .then((response) => {
                        this.clickReset();
                        this.$swal({
                            toast: true,
                            title: response.data.title,
                            icon: response.data.icon,
                            allowOutsideClick: true,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            position: "bottom",
                        });
                    })
                    .catch((err) => {
                        this.$swal({
                            toast: true,
                            title: "มีข้อผิดพลาดบางประการ",
                            icon: "error",
                            text: "โปรดลองอีกครัั้งภายหลัง",
                            allowOutsideClick: true,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            position: "bottom",
                        });
                    });
                loader.hide();
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
