<template>
    <v-snackbar v-model="status" :color="color" right>{{ text }}</v-snackbar>
</template>

<script>
export default {
    props: ["snackbar"],
    data() {
        return {
            status: false,
            color: "",
            text: ""
        };
    },
    computed() {
        if (this.snackbar == "success") {
            this.status = true;
            this.color = "success";
            this.text = "ทำรายการสำเร็จ";
        }

        if (this.snackbar == "error") {
            this.status = true;
            this.color = "error";
            this.text = "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง";
        }
    }
};
</script>

<style></style>
