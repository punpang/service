<template>
    <v-btn :color="setStatusColor(status)" small block>{{
        setStatusText(status)
    }}</v-btn>
</template>

<script>
export default {
    props: ["status"],
    methods: {
        setStatusColor(s) {
            if (s === 1) {
                return "success";
            } else if (s === 0) {
                return "error";
            }
        },
        setStatusText(s) {
            if (s === 1) {
                return "ใช้งานอยู่";
            } else if (s === 0) {
                return "ยกเลิกแล้ว";
            }
        }
    }
};
</script>

<style></style>
