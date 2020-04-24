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
    mounted(){
        this.setSnackber(this.snackbar)
        console.log(this.snackbar);
        
    },
    methods: {
        setSnackber(snackbar) {
            if (snackbar == "success") {
                this.status = true;
                this.color = "success";
                this.text = "ทำรายการสำเร็จ";
            }

            if (snackbar == "error") {
                this.status = true;
                this.color = "error";
                this.text = "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง";
            }
        }
    }
};
</script>

<style></style>
