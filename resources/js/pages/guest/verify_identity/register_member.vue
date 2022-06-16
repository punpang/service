<template>
    <div></div>
</template>

<script>
export default {
    methods: {
        async verify() {
            let loader = this.$loading.show();

            const payload = {
                token: this.$route.params.token,
            };
            const result = await this.$store.dispatch(
                "facebook/register_member",
                payload
            );

            loader.hide();

            this.$swal({
                title: result.data.title,
                icon: result.data.icon,
                text: result.data.text,
                allowOutsideClick: false,
                showConfirmButton: false,
            });
        },
    },
    async mounted() {
        await this.verify();
    },
};
</script>
