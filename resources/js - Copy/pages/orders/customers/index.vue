<template>  
    <div>
        <addCustomer></addCustomer>
        <getCustomer></getCustomer>
    </div>

    
</template>

<script>

import addCustomer from '@/js/components/customers/addCustomer'
import getCustomer from '@/js/components/customers/getCustomer'


export default {
    components:{
        addCustomer,
        getCustomer,
    },
    data() {
        return {
        }
    }
    

}
</script>