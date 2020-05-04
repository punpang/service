<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn color="warning" v-on="on">
                    <v-icon left>cancel</v-icon>
                    ไม่ผ่าน
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    ไม่ผ่านการตรวจสอบ
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    {{ form }}
                    <v-alert type="warning"
                        >การแจ้งชำระนี้ ไม่ผ่านการตรวจสอบ</v-alert
                    >
                    <v-btn color="warning" @click="clickUnVerify">
                        <v-icon left>close</v-icon>
                        ไม่ผ่าน</v-btn
                    >
                    <v-btn color="error" @click="dialog = false">
                        <v-icon left>exit_to_app</v-icon>
                        ออก</v-btn
                    >
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["form"],
    data() {
        return {
            dialog: false
        };
    },
    methods: {
        async clickUnVerify() {
            let response = {};
            response = await this.$store.dispatch(
                "payment/unVerifySlip",
                this.form.slip_id
            );
        }
    }
};
</script>

<style></style>
