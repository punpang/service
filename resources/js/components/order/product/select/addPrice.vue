<template>
  <div>
    <v-dialog persistent width="400" v-model="dialog" scrollable>
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" class="info mr-2">
          <v-icon left>
            {{ msg.icon.add }}
          </v-icon>
          {{ msg.text.add }}</v-btn
        >
      </template>
      <v-card>
        <v-card-title>
          <h3>
            {{ msg.text.add }}
          </h3>
          <v-spacer></v-spacer>
          <v-btn fab icon x-small color="error" @click="close()">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-form lazy-validation ref="form">
            <v-text-field
              :label="msg.text.price"
              v-model="price"
              outlined
              hide-details
              :rules="rules.price"
              type="number"
              pattern="\d*"
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="error" @click="close()">
            <v-icon left>
              {{ msg.icon.exit }}
            </v-icon>
            {{ msg.text.exit }}
          </v-btn>
          <v-btn class="success" @click="save()">
            <v-icon left>
              {{ msg.icon.save }}
            </v-icon>
            {{ msg.text.save }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["propOptions", "propDataSelectedSuccess"],
  data() {
    return {
      dialog: false,
      price: "",
    };
  },
  methods: {
    async save() {
      if (!this.$refs.form.validate() || !this.propDataSelectedSuccess) return;

      const data = {
        ops: this.propOptions,
        price: this.price,
      };
      let loader = this.$loading.show();
      const result = await this.$store.dispatch(
        "orderProductCake/addPrice",
        data
      );

      if (result == 200) {
        this.$swal({
          title: this.msg.text.addSuccess,
          icon: "success",
          allowOutsideClick: false,
          timerProgressBar: true,
          timer: 2000,
        //   confirmButtonText: `เรียบร้อย`,
        });
        this.dialog = false;
      } else {
        this.$swal({
          title: this.msg.text.addError,
          icon: "error",
          allowOutsideClick: false,
          confirmButtonText: `เรียบร้อย`,
        });
      }
      loader.hide();
    },
    close() {
      this.price = "";
      this.dialog = false;
    },
  },
  computed: {
    ...mapGetters({
      msg: "orderProductCake/msg",
      rules: "orderProductCake/rules",
    }),
  },
};
</script>
