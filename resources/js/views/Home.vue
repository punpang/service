<template>
  <div>
    <h2>V Data Table</h2>
    <v-text-field
      v-model="search"
      label="ค้นหา"
      append-icon="search"
      hide-details
    ></v-text-field>
    <v-data-table
      v-model="selected"
      :search="search"
      :headers="headers"
      :items="orders"
      :items-per-page="5"    
      item-key="id"
      show-select
    >
      <template v-slot:item.checked="{ item }">
        <v-simple-checkbox v-model="item.checked"></v-simple-checkbox>
      </template>

      <template v-slot:item.status="{item}">
        <v-chip :color="statusColor(item.status)" dark>{{ item.status }}</v-chip>
      </template>

      <template v-slot:item.action="{ item }">
        <v-icon
          small
          @click="deleteItem(item)"
        >
          delete
        </v-icon>
      </template>

    <template v-slot:item.name="props">
      <v-edit-dialog
      :return-value.sync="props.item.name"
      @save="save"
      @cancel="cancel"
      @open="open"
      @close="close"
      >
        <div>
          {{ props.item.name }}
        </div>
        <template v-slot:input>
          <div class="mt-4 title">Update Iron</div>
        </template>
        
        <template v-slot:input>
          <v-text-field
            v-model="props.item.name"
            label="แก้ไข"
            single-line
            counter
            large
            persistent
            autofocus
          ></v-text-field>
        </template>
      </v-edit-dialog>
    </template>


    </v-data-table>

    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
      {{ snackText }}
      <v-btn text @click="snack = false">Close</v-btn>
    </v-snackbar>

    {{ selected }}
    <hr>
  </div>
</template>

<script>
// @ is an alias to /src


export default {
  data() {
    return {
      snack: false,
      snackColor: '',
      snackText: '',
      search: '',
      selected: [],
      headers:[
        {'text':'หมายเลขคำสั่งซื้อ',value:'id'},
        {'text':'ชื่อลูกค้า',value:'name'},
        {'text':'เบอร์โทร',value:'phone'},
        {'text':'สถานะ',value:'status'},
        {'text':'เลือก',value:'checked'},
        {text:'การจัดการ',value:'action',sortable:false}
      ],
      orders: this.$store.getters.orders
    }
  },
  methods:{
    statusColor(status){
      if(status == 'ชำระหมด') return 'success'
      else if (status == 'รอการชำระเงิน') return 'warning'
    },
    save () {
      this.snack = true
      this.snackColor = 'success'
      this.snackText = 'Data saved'
    },
    cancel () {
      this.snack = true
      this.snackColor = 'error'
      this.snackText = 'Canceled'
    },
    open () {
      this.snack = true
      this.snackColor = 'info'
      this.snackText = 'Dialog opened'
    },
    close () {
      console.log('Dialog closed')
    },
    deleteItem (i) {
      confirm('คุณต้องการลบข้อมูลใช่ไหม') && this.$store.commit('deleteOrder',i)
    }
  }
}
</script>
