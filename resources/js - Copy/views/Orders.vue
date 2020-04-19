<template>
  <div>
      <h1>รายการสั่งซื้อใหม่</h1>
      <hr>
      <v-row>
          <v-col>
              <v-dialog
              v-model="dialog_select_customer"
              width="600">

                <template v-slot:activator="{ on }">
                    <v-btn color="info" 
                    v-on="on">
                        <v-icon left>add</v-icon>
                        เลือกลูกค้า
                    </v-btn>
                </template>

                <v-card>
                    <v-card-title
                    primary-title>                        
                        เลือกลูกค้า
                    </v-card-title>
                    
                    <v-card-text>
                        <v-text-field
                        v-model="search"
                        label="ค้นหาลูกค้า"
                        append-icon="search"
                        >
                        </v-text-field>

                        <v-data-table
                        :search="search"
                        :headers="header_customer"
                        :items="dataCustomers"
                        item-key="id">   
                        <template v-slot:item.action="{ item }">
                            <v-btn @click="select_customer(item)" color="primary" block>
                            เลือก
                            </v-btn>
                        </template>                         
                        </v-data-table>


                    </v-card-text>
                </v-card>

              </v-dialog>

          </v-col>

      </v-row>
      <hr class="mb-2">
      <v-form
      ref="FormNewOrder"
      lazy-validation>
        <h3>ข้อมูลลูกค้า</h3>
        <v-row>
            <v-col cols="12" md="6">
                <v-text-field label="ชื่อลูกค้า" v-model="customer.name" readonly 
                :rules="[v=>!!v || 'ห้ามเว้นว่าง']">
                </v-text-field>
            </v-col>
            <v-col cols="12" md="6">
                <v-text-field label="เบอร์โทรลูกค้า" v-model="customer.phone" readonly
                :rules="[v=>!!v || 'ห้ามเว้นว่าง']">>
                </v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-btn color="success" @click="save">
                    <v-icon left>save</v-icon>
                    บันทึก</v-btn>
            </v-col>
            <v-col cols="12" md="4">
                <v-btn color="error" @click="reset">
                    <v-icon left>delete</v-icon>
                    ล้างข้อมูล</v-btn>
            </v-col>
        </v-row>

        
      </v-form>
        <v-snackbar v-model="snackbar.NewOrder" color="success">{{ snackbarText.NewOrder }}</v-snackbar>
        <v-snackbar v-model="snackbar.reset" color="success">{{ snackbarText.reset }}</v-snackbar>

  </div>
</template>

<script>
export default {
    data() {
        return {
            snackbar:{
                reset:false,
                NewOrder:false
           },
            snackbarText:{
                reset : 'ล้างข้อมูลเรียบร้อย',
                NewOrder :'สร้างรายการสั่งซื้อใหม่เรียบร้อย'
            },
            customer:{},
            search:'',
            dialog_select_customer : false,
            header_customer:[
                {text:'ชื่อลูกค้า',value:'name'},
                {text:'เบอร์โทร',value:'phone'},
                {text:'การจัดการ',value:'action'}
            ],
            dataCustomers : this.$store.getters.customers
        }
    },
    methods : {
        select_customer(i){
            this.customer = {
                name : i.name,
                phone : i.phone
            },
            this.dialog_select_customer = false
        },
        save(){
             if(this.$refs.FormNewOrder.validate()){
                this.$store.commit('addOrder',this.customer);
                this.$refs.FormNewOrder.reset();
                this.snackbar.NewOrder = true
             }        
        },
        reset(){
                this.$refs.FormNewOrder.reset();
                this.snackbar.reset = true
        }
    }
}
</script>

<style>

</style>