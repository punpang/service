<template>
    <div>
        <h1>Form Vue</h1>
        <hr>
        
        <v-form
        ref="form"
        v-model="valid"
        lazy-validation>
                <v-row>
                    <v-col
                    cols="12"
                    md="4"
                    >
                        <v-text-field 
                        v-model="form.name"
                        required
                        :counter=10
                        :rules="nameRules"
                        label="ชื่อลูกค้า"
                        ></v-text-field>
                    </v-col>

                    <v-col
                    cols="12"
                    md="4"
                    >
                        <v-text-field 
                        required
                        v-model="form.phone" 
                        label="เบอร์โทรลูกค้า"
                        :counter=10
                        :rules="phoneRules">
                        </v-text-field>
                    </v-col>
                    <!-- 
                    <v-col
                    cols="12"
                    md="4"
                    >
                        <v-select
                        v-model="Qq"
                        :items="itemsQ"
                        label="คิว"
                        required
                        :rules="[v=> !!v || 'กรุณาเลือกคิว']"
                        ></v-select>
                    </v-col>
                    -->
                    <v-col>
                        <v-btn
                        :disabled="!valid"
                        color="success"
                        @click="submit"
                        ><v-icon left>save</v-icon>บันทึกข้อมูล</v-btn>
                        <v-btn
                        color="error"
                        class="ml-4"
                        @click="clearAll"
                        ><v-icon left>clear</v-icon>ล้างข้อมูล</v-btn>
                    </v-col>      
                </v-row>

        </v-form>
        <v-snackbar v-model="snackbar" color="success">{{ text }}</v-snackbar>

        <v-text-field v-model="search" label="ค้นหาลูกค้า" append-icon="search"></v-text-field>
        <v-data-table
        :headers="HeaderCustomer"
        item-key="id"
        :items="TableCustomer"
        :search="search"
        >
        <template v-slot:item.action="{item}">
            <v-icon color="error" @click="remove(item)">delete</v-icon>
        </template>
        </v-data-table>
               
    </div>
</template>

<script>
export default {
    data() {
        return {            
            valid:true,
            customers: this.$store.getters.customers,
            snackbar:false,
            text:'บันทึกสำเร็จ !!',
            form:{
                name:'',
                phone:'',
            },
            Qq: null,
            itemsQ : [
                '1','2','3','4','5'
            ],
            nameRules:[
                v => !!v || 'กรุณากรอก ห้ามเว้นว่าง',
                v => v.length <= '10'
            ],
            phoneRules:[
                v => !!v || 'กรุณากรอก ห้ามเว้นว่าง',
                v => v.length == '10' || 'กรุณากรอก 10 หลักเท่านั้น',
                v => {
                    const pattern = /[0]{1}[0-9]{9}/
                    return pattern.test(v) || 'กรุณากรอกให้ถูกต้อง เช่น 0123456789'
                }
            ],
            HeaderCustomer:[
                {text:'ชื่อลูกค้า',value:'name'},
                {text:'เบอร์โทร',value:'phone'},
                {text:'การจัดการ',value:'action'}
            ],
            TableCustomer : this.$store.getters.customers,
            search:'',
        }
    },
    methods:{
        submit(){
            if(this.$refs.form.validate()){
                this.$store.commit('addCustomer',this.form)
                this.$refs.form.reset()
                this.snackbar = true
            }
        },
        clearAll(){
            this.$refs.form.reset()
        },
        remove(i){
            confirm('คำเตือน : คุณต้องการลบลูกค้า : ' + i.name + ' ใช่ไหม!!') && this.$store.commit('deleteCustomer',i)
        }
    }
}
</script>