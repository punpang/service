<template>
  <h1>test show</h1>
</template>

<script>
export default {
    data() {
        return {
            token:"",
            order
        }
    },
    async mounted(){
        this.token =this.$route.params.token;
        this.order = await axios.get('/api/v1/guest/order/'+this.token)
        console.log(this.order);
        
    }
}
</script>

<style>

</style>