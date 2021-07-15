<template>
    <div>
        
    </div>
</template>

<script>
export default {
    async mounted() {
        await this.$store.dispatch("tableOrder/self")
    },
}
</script>