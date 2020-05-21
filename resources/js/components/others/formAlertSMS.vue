<template>
    <v-checkbox
        label="แจ้งผ่านข้อความ"
        v-model="alertSMS"
        hide-details
        @change="emitAlertSMS(alertSMS)"
    ></v-checkbox>
</template>

<script>
export default {
    props:[
        "alertSMS"
    ],
    methods: {
        emitAlertSMS(sms) {
            const alert = {
                sms: sms
            };
            this.$emit("emitAlert", alert);
        }
    }
};
</script>

<style></style>
