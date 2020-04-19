<template>
    <div>
        <v-dialog v-model="dialogEdit" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" color="warning" fab x-small>
                    <v-icon>edit</v-icon>
                </v-btn>
            </template>
            <v-form lazy-validation ref="editForm">
                <v-card>
                    <v-card-title>
                        <h3>แก้ไขข้อมูล</h3>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="dialogEdit = false">
                            <v-icon color="error">close</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            label="ชื่อลูกค้า"
                            v-model="form.name"
                            :rules="[v => !!v || 'ห้ามเว้นว่าง']"
                            append-icon="person"
                        ></v-text-field>
                        <v-text-field
                            label="เบอร์โทร"
                            v-model="form.phone"
                            :counter="10"
                            :rules="[
                                v => !!v || 'ห้ามเว้นว่าง',
                                v =>
                                    v.length == 10 ||
                                    'กรอกเบอร์โทร 10 หลักเท่านั้น',
                                v => {
                                    const pattern = /[0]{1}[0-9]{9}/;
                                    return (
                                        pattern.test(v) ||
                                        'กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น'
                                    );
                                }
                            ]"
                            append-icon="phone"
                        ></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="success"
                            @click="save"
                            :loading="loadSave"
                        >
                            <v-icon left>edit</v-icon>
                            บันทึกข้อมูล
                        </v-btn>
                        <v-btn color="error" @click="dialogEdit = false">
                            <v-icon left>close</v-icon>
                            ยกเลิก
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <v-snackbar v-model="snackbar.status" :color="snackbar.color" right>{{
            snackbar.text
        }}</v-snackbar>
    </div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            dialogEdit: false,
            loadSave: false,
            form: {
                id: this.data.id,
                name: this.data.name,
                phone: this.data.phone
            },
            snackbar: {
                status: false,
                color: "",
                text: ""
            }
        };
    },
    methods: {
        //
        async save() {
            if (this.$refs.editForm.validate()) {
                this.loadSave = true;
                const response = await this.$store.dispatch(
                    "customer/edit",
                    this.form
                );
                console.log(response);
                if (response.status === 200) {
                    this.loadSave = false;
                    this.dialogEdit = false;
                    this.snackbar = {
                        color: "success",
                        text: "แก้ไขข้อมูลสำเร็จ",
                        status: true
                    };
                } else if (response.status === 422) {
                    this.form.phone = "";
                    this.snackbar = {
                        color: "warning",
                        text: response.data.errors.phone[0],
                        status: true
                    };
                    this.loadSave = false;
                } else {
                    this.snackbar = {
                        color: "warning",
                        text: "เกิดข้อผิดพลาดบางอย่างขึ้น กรุณาลองอีกครั้ง",
                        on: true
                    };
                } // end เบอร์ซ้ำ
            }
        },
        savea() {
            if (this.$refs.editForm.validate()) {
                this.loadSave = true;
                axios
                    .post(
                        "/api/customer/" + this.data.id + "/edit",
                        {
                            name: this.form.name,
                            phone: this.form.phone
                        },
                        {
                            headers: {
                                Authorization: this.$store.getters[
                                    "main/AuthToken"
                                ]
                            }
                        }
                    )
                    .then(res => {
                        this.$store.commit("customer/getCustomers", res.data);
                        this.loadSave = false;
                        this.dialogEdit = false;
                        this.snackbar = {
                            color: "success",
                            text: "แก้ไขข้อมูลสำเร็จ",
                            status: true
                        };
                    })
                    .catch(err => {
                        if (err.response.status == 422) {
                            this.snackbar = {
                                status: true,
                                color: "error",
                                text: err.response.data.errors.phone[0]
                            };
                        } else {
                            this.snackbar = {
                                status: true,
                                color: "warning",
                                text: "กรุณาลองอีกครั้งภายหลัง"
                            };
                        }
                        this.loadSave = false;
                    });
            }
        }
        //
    }
};
</script>

<style></style>
