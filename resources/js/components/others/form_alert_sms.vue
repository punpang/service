<template>
    <v-checkbox
        label="แจ้งผ่านข้อความ"
        v-model="alertSMS"
        @change="emitAlertSMS(alertSMS)"
    ></v-checkbox>
</template>

<script>
export default {
    data() {
        return {
            alertSMS: true
        };
    },
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
