<template>
  <div>
        <v-text-field v-model="search" label="ค้นหาลูกค้า" append-icon="search"></v-text-field>
        <v-data-table
        :headers="headerTable"
        :items="this.$store.getters['customer/getCustomers']"
        :loading="loadingTable"
        :search="search"
        no-results-text="ไม่พบข้อมูลที่ค้นหา"
        loading-text="รอสักครู่...กำลังโหลดข้อมูล"
        item-key="id"
        >
            <template v-slot:item.action="{item}">
                <v-row>
                    <editCustomer :data="item"></editCustomer>
                    <deleteCustomer :data="item"></deleteCustomer>
                </v-row>
            </template>
        </v-data-table>
  </div>
</template>

<script>
import editCustomer from '@/js/components/customers/edit'
import deleteCustomer from '@/js/components/customers/delete'

export default {
    components:{
        editCustomer,
        deleteCustomer
    },
    data() {
        return {
            loadingTable: true,
            search:"",   
            headerTable:[
                {text:'ชื่อลูกค้า',value:'name'},
                {text:'เบอร์โทร',value:'tel'},
                {text:'การจัดการ',value:'action'}
            ],
            snackbar:{}
        }
    }, 
    methods:{
        remove(){
            confirm('คุณต้องการลบใช่หรือไม่')
        }
    },
    created() {
        axios.get('/api/customer',{
            headers: {
                Authorization: this.$store.getters['main/AuthToken']
            }
        }).then(res => {
            this.$store.commit("customer/getCustomers",res.data)      
            this.snackbar = {
                color : 'success',
                text : 'โหลดข้อมูลสำเร็จ',
                on : true
            }          
            this.loadingTable = false
        })
    }

}
</script>

<style>

</style>