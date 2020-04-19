<template>
        <v-data-table
            :items="dataOrders"
            :headers="header"
            item-key="id"
            :loading="loadingTable"
            loading-text="รอสักครู่..กำลังโหลดข้อมูล">
            <template v-slot:item.action="{}">
                <v-icon color="error">
                    delete
                </v-icon>
            </template>
        </v-data-table>
</template>

<script>
    export default {
        data() {
            return {
                dataOrders:[],
                header:[
                    {text:'หมายเลขคำสั่งซื้อ',value:'id'},
                    {text:'วันที่รับ',value:'date_get'},
                    {text:'เวลาที่รับ',value:'time_get'},
                    {text:'วันเวลาที่สร้าง',value:'created_at'},
                    {text:'การจัดการ',value:'action'}
                ],
                loadingTable :true,

            }
        },
        created() {
            
            axios.get('/api/test', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            },
            ).then(response => {
                this.dataOrders = response.data
                this.loadingTable = false
            });
        }
    }
</script>