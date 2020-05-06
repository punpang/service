<template>
    <div>
        <v-dialog v-model="dialogDelete" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn color="error" v-on="on" fab x-small>
                    <v-icon>delete</v-icon>
                </v-btn>
            </template>

            <v-card>
                <v-card-title>
                    <h3>ลบข้อมูล</h3>
                    <v-spacer></v-spacer>
                    <v-btn icon color="error" @click="dialogDelete = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                        v-model="form.name"
                        readonly
                        label="ชื่อลูกค้า"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.phone"
                        readonly
                        label="เบอร์โทร"
                    ></v-text-field>
                    <v-alert type="warning">ต้องการลบข้อมูลนี้หรือไม่</v-alert>
                    กรุณากรอกคำว่า <b>"ลบข้อมูล"</b> ลงในช่องว่าง
                    <v-form ref="deleteForm" lazy-validation>
                        <v-text-field
                            v-model="confirm"
                            autofocus
                            :counter="8"
                            :rules="[
                                v => !!v || 'ห้ามเว้นว่าง',
                                v => v.length == 8
                            ]"
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="warning" @click="submitDelete">
                        <v-icon left>delete</v-icon>
                        ลบข้อมูล
                    </v-btn>
                    <v-btn color="error" @click="dialogDelete = false">
                        <v-icon left>close</v-icon>
                        ปิด
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            dialogDelete: false,
            confirm: "",
            form: {
                name: this.data.name,
                phone: this.data.phone
            },
        };
    },
    methods: {
        submitDelete() {
            if (this.$refs.deleteForm.validate()) {
                if (this.confirm == "ลบข้อมูล") {
                    this.$toast.success('ลบข้อมูลเรียบร้อย')
                    this.$refs.deleteForm.reset();
                } else {
                    this.$toast.error("กรุณากรอกคำว่า 'ลบข้อมูล' ลงในช่องว่าง")
                }
            }
        }
    }
};
</script>

<style></style>
