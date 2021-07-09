<template>
  <div>
    <v-dialog persistent v-model="dialog" width="500">
      <template v-slot:activator="{ on }">
        <v-btn color="success" block v-on="on">
          <v-icon left>add</v-icon>
          เมนูรอง</v-btn
        >
      </template>
      <v-card>
        <v-card-title>
          <h3>เพิ่มเมนูรอง</h3>
          <v-spacer></v-spacer>
          <v-btn icon fab x-small @click="(dialog = false), reset()">
            <v-icon color="error">close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-form ref="form" lazy-validation>
          <v-card-text>
            {{ form }}
            <v-text-field
              outlined
              label="หัวข้อ"
              placeholder="จัดการสินค้า"
              v-model="form.title"
              :rules="rules.title"
              autofocus
            ></v-text-field>

            <selectMain
              @emitSelectMain="emitSelectMain"
              :prop_menu_main_id="form.menu_main_id"
              :prop_rule_menu_main_id="rules.menu_main_id"
            ></selectMain>

            <v-text-field
              outlined
              label="URL"
              placeholder="/home"
              v-model="form.to"
              :rules="rules.to"
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
import selectMain from "@/js/components/shabuNoonee/menuBar/_selectMain";

export default {
  components: {
    formCheckBoxType,
    selectMain,
  },
  data() {
    return {
      dialog: false,
      loading: false,
      form: {
        title: "",
        to: "",
        menu_main_id: null,
        admin: true,
        cashier: false,
        waitress: false,
        kitchen: false,
        customer: false,
      },
      rules: {
        title: [(v) => !!v || "ห้ามเว้นว่าง"],
        to: [(v) => !!v || "ห้ามเว้นว่าง"],
        menu_main_id: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    emitSelectMain(v) {
      this.form.menu_main_id = v;
    },
    emitFormCheckBoxType(v) {
      this.form.admin = v.admin;
      this.form.cashier = v.cashier;
      this.form.waitress = v.waitress;
      this.form.kitchen = v.kitchen;
      this.form.customer = v.customer;
    },
    async save() {
      this.loading = true;
      if (this.$refs.form.validate() && this.form.menu_main_id != null) {
        console.log("pass");
      }
      this.loading = false;
    },
    reset() {
      this.form = {
        title: "",
        action: "",
        menu_main_id: null,
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