<template>
  <v-simple-table>
    <template v-slot:default>
      <tbody>
        <tr>
          <td>admin</td>
          <td>
            <v-checkbox
              v-model="checkbox.admin"
              @change="changeCheckbox()"
            ></v-checkbox>
          </td>
        </tr>
        <!-- <tr>
          <td>cashier</td>
          <td>
            <v-checkbox
              v-model="checkbox.cashier"
              @change="changeCheckbox()"
            ></v-checkbox>
          </td>
        </tr>
        <tr>
          <td>waitress</td>
          <td>
            <v-checkbox
              v-model="checkbox.waitress"
              @change="changeCheckbox()"
            ></v-checkbox>
          </td>
        </tr>
        <tr>
          <td>kitchen</td>
          <td>
            <v-checkbox
              v-model="checkbox.kitchen"
              @change="changeCheckbox()"
            ></v-checkbox>
          </td>
        </tr> -->
        <tr>
          <td>customer</td>
          <td>
            <v-checkbox
              v-model="checkbox.customer"
              @change="changeCheckbox()"
            ></v-checkbox>
          </td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
export default {
  props: [],
  data() {
    return {
      checkbox: {
        admin: true,
        cashier: false,
        waitress: false,
        kitchen: false,
        customer: false,
      },
    };
  },
  methods: {
    changeCheckbox() {
        this.$emit("emitFormCheckBoxType",this.checkbox)
    },
  },
};
</script>
