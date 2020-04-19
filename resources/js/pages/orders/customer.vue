<template>
    <div>
        <addCustomer :search="search"></addCustomer>
        <getCustomer :selectCustomerInGet="selectCustomer" @onCustomer="onCustomer" @onSearch="onSearch"></getCustomer>
    </div>
</template>

<script>
import addCustomer from "@/js/components/customers/addCustomer";
import getCustomer from "@/js/components/customers/getCustomer";

export default {
    props:[
        "selectCustomer"
    ],
    components: {
        addCustomer,
        getCustomer
    },
    data() {
        return {
            search:''
        };
    },
    methods:{
        onCustomer(value){
            this.$emit('onCustomer',value)
        },
        onSearch(value){
            this.search = value         
        }
    }
};
</script>
