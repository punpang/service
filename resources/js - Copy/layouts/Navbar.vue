<template>
<v-navigation-drawer app v-if="this.$store.getters.isLoggedIn == true && this.$store.getters.drawerMain == true">
        <v-dialog v-if="false"
          v-model="dialog"
          width="500">
        <template v-slot:activator="{ on }">
            <v-btn
              color="info"
              v-on="on"
              >
                  <v-icon>
                      add
                  </v-icon>
                  เพิ่ม
            </v-btn>
        </template>

        <v-card>
            <v-card-title>
                เพิ่มข้อมูล
            </v-card-title>
            <v-card-text>
                <v-form
                ref='FormNewOrder'
                v-model='NewOrder'
                lazy-validation
                >
                    <v-row>
                        <v-col
                        cols="12"
                        md="6">
                            <v-text-field v-model="form.name" label="ชื่อลูกค้า" required
                            :rules="[v=> !!v || 'ห้ามเว้นว่าง']"></v-text-field>
                        </v-col>

                        <v-col
                        cols="12"
                        md="6">
                            <v-text-field v-model="form.phone" :counter="10" label="เบอร์โทร" required
                            :rules="[
                            v=>!!v || 'ห้ามเว้นว่าง',
                            v=> v.length == 10 || 'กรอกเบอร์โทร 10 หลักเท่านั้น',
                            v => {
                                const pattern = /[0]{1}[0-9]{9}/
                                return pattern.test(v) || 'กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น'
                            }]"></v-text-field>
                        </v-col>
                    </v-row>               

                


                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="success" text @click="New">บันทึก</v-btn>
                <v-btn color="red" text @click="Reset">ล้างข้อมูล</v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
        <v-list>
            <v-list-item 
            link
            v-for="menu in menus"
            :key="menu.name"
            :to="menu.to"
            >
                <v-list-item-icon> 
                    <v-icon>{{menu.icon}}</v-icon>
                </v-list-item-icon>              
                    
                <v-list-item-content>
                    <v-list-item-title>{{menu.title}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        
    </v-navigation-drawer>
    
</template>

<script>

export default {    
    data() {
        return {                            
            NewOrder:true,
            form:{
                name:'',
                phone:''
            },
            dialog:false,
            menus:[
                {'icon':'home','title':'หน้าแรก','to':'/'},
                {'icon':'person','title':'ลูกค้า','to':'/customers'},
            ],
            drawer: true
        }
    },
    methods:{
        New(){
            if(this.$refs.FormNewOrder.validate()){
                this.$store.commit('addOrder',this.form);
                this.$refs.FormNewOrder.reset();
                this.dialog = false
            }
        },
        Reset(){
            this.$refs.FormNewOrder.reset();
        }
    }
}
</script>