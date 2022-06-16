<template></template>

<script>
export default {
    methods: {
        async fetch() {
            let loader = this.$loading.show();
            this.$swal({
                title: "กำลังเปลี่ยนหน้า",
                icon: "warning",
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            const result = await axios.get(
                `/api/v1/guest/shotlink/${this.$route.params.shotlink}`
            );

            if (result.data.status == "error") {
                this.$swal({
                    title: "ลิงก์หมดอายุ",
                    icon: "error",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            } else {
                window.location.href = result.data;
            }
            loader.hide();
        },
    },
    async mounted() {
        await this.fetch();
    },
};
</script>
