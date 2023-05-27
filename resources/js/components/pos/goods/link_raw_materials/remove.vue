<template>
    <v-btn icon fab x-small v-on="on" @click="clickRemove(propLinkRawMaterial)">
        <v-icon color="error">delete</v-icon>
    </v-btn>
</template>

<script>
export default {
    props: ["propLinkRawMaterial"],
    methods: {
        clickRemove(v) {
            this.$swal({
                icon: "warning",
                title: "คุณต้องการลบออกใช่ไหม",
                text: "",
                showCancelButton: true,
                confirmButtonColor: "#38c172",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่, ลบเลย",
                cancelButtonText: "ไม่ใช่, ออก",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.remove(v);
                }
            });
        },
        async remove(v) {
            let loader = this.$loading.show();
            const result = await this.$store
                .dispatch("posLinkRawMaterial/remove", v)
                .then((result) => {
                    this.$swal({
                        toast: true,
                        title: result.data.title,
                        icon: result.data.icon,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    this.$emit("emitFetchGoods");
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        icon: "error",
                        title: "เกิดข้อผิดพลาดบางประการ",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        position: "bottom",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            loader.hide();
        },
    },
};
</script>

<style></style>
