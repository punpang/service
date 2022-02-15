<template>
  <div>
    <v-simple-table>
      <tbody>
        <tr>
          <td>
            {{ messages.nameCustomer }}
          </td>
          <td class="text-right">
            {{ getSearch.name }}
          </td>
        </tr>

        <tr>
          <td>
            {{ messages.phoneNumberCustomer }}
          </td>
          <td class="text-right">
            {{ getSearch.tel }}
          </td>
        </tr>
      </tbody>
    </v-simple-table>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      form: { nameCustomer: "" },
    };
  },
  methods: {},
  computed: {
    ...mapGetters({
      getSearch: "orderCustomer/getSearch",
      rules: "orderCustomer/rules",
      messages: "orderCustomer/messages",
    }),
  },
};
</script>

<style>
</style>