<template>
  <div>
    <v-dialog persistent v-model="dialog" width="500">
      <template v-slot:activator="{ on }">
        <v-btn color="success" block v-on="on">
          <v-icon left>add</v-icon>
          เมนูหลัก</v-btn
        >
      </template>
      <v-card>
        <v-card-title>
          <h3>เพิ่มเมนูหลัก</h3>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="(dialog = false), reset()">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-form ref="form" lazy-validation>
          <v-card-text>
            <v-text-field
              outlined
              label="หัวข้อ"
              placeholder="จัดการสินค้า"
              v-model="form.title"
              :rules="rules.title"
            ></v-text-field>
            <v-text-field
              outlined
              label="ไอคอน"
              placeholder="home"
              v-model="form.action"
            ></v-text-field>
            <formCheckBoxType
              @emitFormCheckBoxType="emitFormCheckBoxType"
            ></formCheckBoxType>
          </v-card-text>
        </v-form>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="success" @click="save()" :loading="loading">
            <v-icon left>save</v-icon>
            บันทึก
          </v-btn>
          <v-btn color="error" @click="reset()">
            <v-icon left>clear</v-icon>
            ล้างข้อมูล
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import formCheckBoxType from "@/js/components/shabuNoonee/menuBar/_form_checkboxType";
export default {
  components: {
    formCheckBoxType,
  },
  data() {
    return {
      dialog: false,
      loading: false,
      form: {
        title: "",
        action: "",
        admin: true,
        cashier: false,
        waitress: false,
        kitchen: false,
        customer: false,
      },
      rules: {
        title: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    emitFormCheckBoxType(v) {
      this.form.admin = v.admin;
      this.form.cashier = v.cashier;
      this.form.waitress = v.waitress;
      this.form.kitchen = v.kitchen;
      this.form.customer = v.customer;
    },
    async save() {
      this.loading = true;
      if (this.$refs.form.validate()) {
        const res = await this.$store.dispatch("menuBar/storeMain", this.form);
        if (res.status === 200 && res.data.status === "success") {
          this.$toast.success(res.data.message);
          this.reset();
          this.dialog = false;
        }
      }
      this.loading = false;
    },
    reset() {
      this.form = {
        title: "",
        action: "",
        admin: true,
        cashier: false,
        waitress: false,
        kitchen: false,
        customer: false,
      };
    },
  },
};
</script>