<template>
    <div>
        <v-list-item v-on="on" @click="confirm_click()">
            <v-list-item-title> สรุปรายการส่งไปยังลูกค้า </v-list-item-title>
        </v-list-item>
    </div>
</template>

<script>
export default {
    props: ["propOrder"],
    methods: {
        confirm_click() {
            this.$swal({
                title: "ต้องการส่งสรุปใช่ไหม ?",
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "ใช่ ,ส่งเลย",
                denyButtonText: "ไม่ใช่ ,ออก",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.clickSend();
                }
            });
        },

        async clickSend() {
            const payload = {
                order_id: this.propOrder.id,
            };
            let loader = this.$loading.show();
            await this.$store
                .dispatch("orderIndex/summaryOfOrderDetails", payload)
                .then((result) => {
                    this.$swal({
                        toast: true,
                        title: result.title,
                        icon: result.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                    });
                    this.$emit("emitExit");
                })
                .catch((error) => {
                    this.$swal({
                        toast: true,
                        title: "มีบางอย่างผิดพลาด",
                        icon: "error",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                    });
                    console.log(
                        "🚀 ~ file: btn.vue:23 ~ ).then ~ error",
                        error
                    );
                });

            loader.hide();
        },
    },
};
</script>

<style></style>
>
