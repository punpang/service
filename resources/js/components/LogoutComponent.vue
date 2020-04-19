<template>

</template>

<script>
    export default {
        mounted () {
            localStorage.removeItem('token')
            this.$store.commit('main/logoutUser')
            this.$router.push({ name: 'login' })
        }
    }
</script>