<template>
  <div>
    <v-dialog v-model="dialog" persistent width="500">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" color="warning" fab x-small>
          <v-icon>edit</v-icon>
        </v-btn>
      </template>
      <v-form lazy-validation ref="form">
        <v-card>
          <v-card-title>
            <h3>แก้ไขกลุ่มสินค้า</h3>
            <v-spacer></v-spacer>
            <v-btn icon @click="dialog = false">
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

              {{ item.name }}
              {{ form.name }}
            </v-col>
          </v-card-text>
          <v-divider class="ma-0"></v-divider>
          <v-card-actions class="pa-0">
            <v-col>
              <v-btn
                color="success"
                @click="save()"
                :loading="loading"
                :disabled="item.name == form.name"
              >
                <v-icon left>save</v-icon>
                บันทึก
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
  props: ["item"],
  data() {
    return {
      dialog: false,
      loading: false,
      form: {
        id: this.item.id,
        name: this.item.name,
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
        const res = await this.$store.dispatch(
          "productGroup/update",
          this.form
        );
        if (res.status === 200) {
          this.$toast.success(res.data.message);
        } else {
          this.$toast.error("ระบบทำรายการไม่สำเร็จ");
        }
        this.loading = false;
        this.dialog = false;
      }
    },
  },
};
</script>