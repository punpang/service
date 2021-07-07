<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="success" fab x-small>
          <v-icon>add</v-icon>
        </v-btn>
      </template>

      <v-form ref="form" lazy-validation>
        <v-card>
          <v-card-title>
            <h3>เพิ่มกลุ่มสินค้า</h3>
            <v-spacer></v-spacer>
            <v-btn icon @click="(dialog = false), reset()">
              <v-icon color="error">close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text class="pa-0">
            <v-col class="pt-0 pb-0">
              <v-text-field
                outlined
                v-model="form.name"
                label="ชื่อกลุ่มสินค้า"
                :rules="roles.name"
              ></v-text-field>
              <v-switch
                inset
                v-model="form.status"
                class="mt-0"
                label="สถานะ"
              ></v-switch>
            </v-col>
          </v-card-text>
          <v-divider class="ma-0"></v-divider>
          <v-card-actions class="pa-0">
            <v-col>
              <v-btn color="success" @click="save" :loading="loading">
                <v-icon left>save</v-icon>
                บันทึก
              </v-btn>
              <v-btn color="error" @click="reset">
                <v-icon left>clear</v-icon>
                ล้างข้อมูล
              </v-btn>
            </v-col>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      loading: false,
      form: {
        name: "",
        status: true,
      },
      roles: {
        name: [(v) => !!v || "ห้ามเว้นว่าง"],
      },
    };
  },
  methods: {
    async save() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        const res = await this.$store.dispatch("productGroup/store", this.form);
        if (res.status === 200) {
          this.$toast.success(res.data.message);
        }
        this.reset();
        this.loading = false;
      }
    },
    reset() {
      this.form = {
        name: "",
        status: true,
      };
    },
  },
};
</script>