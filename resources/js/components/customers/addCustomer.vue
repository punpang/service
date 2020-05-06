<template>
    <v-row>
        <v-col>
            <h3>รายชื่อลูกค้า</h3>
            <v-dialog v-model="dialogAddCustomer" persistent width="500">
                <template v-slot:activator="{ on }">
                    <v-btn color="info" v-on="on" @click="start">
                        <v-icon left>add</v-icon>
                        เพิ่มลูกค้ารายใหม่
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title>
                        <h3>เพิ่มลูกค้ารายใหม่</h3>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="dialogAddCustomer = false">
                            <v-icon color="error">close</v-icon>
                        </v-btn>
                    </v-card-title>

                    <v-card-text>
                        <v-form ref="addCustomerForm" lazy-validation>
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
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="success"
                            @click="submit"
                            :loading="loadingSubmit"
                            ><v-icon left>save</v-icon>เพิ่มลูกค้าใหม่</v-btn
                        >
                        <v-btn color="error" @click="reset"
                            ><v-icon left>refresh</v-icon>ล้างข้อมูล</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-col>
        <v-spacer></v-spacer>

    </v-row>
</template>

<script>
export default {
    props:[
        'search'
    ],
    data() {
        return {
            loadingSubmit: false,
            dialogAddCustomer: false,
            form: {
                name: "",
                phone: ""
            },
        };
    },
    methods: {
        start(){
            this.form.phone = this.search;
        },
        async submit() {
            if (this.$refs.addCustomerForm.validate()) {
                // start สร้างลูกค้าใหม่
                this.loadingSubmit = true;
                const response = await this.$store.dispatch(
                    "customer/add",
                    this.form
                );
                if (response.status === 200) {
                    this.$toast.success('สำเร็จ')
                    this.dialogAddCustomer = false;
                    this.loadingSubmit = false;
                    this.$refs.addCustomerForm.reset();
                } else if (response.status === 422) {
                    this.form.phone = "";
                     this.$toast.warning(response.data.errors.phone[0])
                    this.loadingSubmit = false;
                } else {
                    this.$toast.warning('เกิดข้อผิดพลาดบางอย่างขึ้น กรุณาลองอีกครั้ง')
                } // end เบอร์ซ้ำ this.loadingSubmit = false; });
            } else {
                this.$toast.warning('โปรดกรอกข้อมูลให้ถูกต้อง')
            }
        },
        reset() {
            this.$refs.addCustomerForm.reset();
            this.$toast.error('ล้างสำเร็จ')
        }
    }
};
</script>

<style></style>
