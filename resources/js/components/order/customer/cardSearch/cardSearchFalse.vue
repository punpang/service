<template>
  <div>
    <v-dialog persistent width="400" v-model="dialog">
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="orange white--text" block x-large>
          <v-icon left>
            {{ msgCustomer.icon.add }}
          </v-icon>
          {{ msgCustomer.text.addNewCustomer }}
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <h3>
            {{ msgCustomer.text.addNewCustomer }}
          </h3>
          <v-spacer></v-spacer>
          <v-btn fab icon x-small color="error" @click="close()">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-form lazy-validation ref="form">
            <v-text-field
              :label="msgCustomer.text.phoneNumberCustomer"
              v-model="propPhoneNumber"
              outlined
              :rules="rules.phone_number"
              disabled
            ></v-text-field>
            <v-text-field
              :label="msgCustomer.text.nameCustomer"
              autofocus
              outlined
              v-model="nameCustomer"
              :rules="rules.name"
            ></v-text-field>
            <v-text-field
              :label="msgCustomer.text.social"
              v-model="social"
              outlined
              :rules="rules.social"
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <!-- // ปุ่มเพิ่มลูกค้า -->
          <v-btn x-large class="success" @click="save()">
            <v-icon left>
              {{ msgCustomer.icon.add }}
            </v-icon>
            {{ msgCustomer.text.addNewCustomer }}
          </v-btn>
          <!-- // ปุ่มล้างข้อมูล -->
          <v-btn x-large class="error" @click="reset()">
            <v-icon left>
              {{ msgCustomer.icon.refresh }}
            </v-icon>
            {{ msgCustomer.text.refresh }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["propPhoneNumber"],
  data() {
    return {
      dialog: false,
      nameCustomer: "",
      social: "",
    };
  },
  methods: {
    async save() {
      if (this.$refs.form.validate()) {
        let loader = this.$loading.show();
        const form = {
          name: this.nameCustomer,
          tel: this.propPhoneNumber,
          social_is: this.social,
        };

        const res = await this.$store.dispatch("orderCustomer/store", form);
        if (res.status === 201) {
          this.$toast.success(this.msgCustomer.text.successAddNewCustomer);
        } else {
          console.log(res);
        }
        this.close();
        loader.hide();
      }
    },
    reset() {
      this.nameCustomer = "";
      this.social = "";
    },
    close() {
      this.reset();
      this.dialog = false;
    },
  },
  computed: {
    ...mapGetters({
      msgCustomer: "orderCustomer/messages",
      rules: "orderCustomer/rules",
    }),
  },
};
</script>
