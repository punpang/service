<template>
  <div>
    <v-row>
      <v-col><h1>แสดงเมนู</h1></v-col>
      <v-spacer></v-spacer>
      <v-col class="text-right col-3">
        <addMenuMain></addMenuMain>
      </v-col>
      <v-col class="text-right col-3">
        <addMenusSub></addMenusSub>
      </v-col>
    </v-row>

    <v-card v-for="menuMain in menuMains" :key="menuMain.id" class="mb-4">
      <v-card-title>{{ menuMain.title }}</v-card-title>
      <v-card-text>
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left"></th>
                <th class="text-left">admin</th>
                <!-- <th class="text-left">cashier</th>
                <th class="text-left">waitress</th>
                <th class="text-left">kitchen</th> -->
                <th class="text-left">customer</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#</td>
                <td>
                  <v-checkbox
                    v-model="menuMain.admin"
                    @change="changeMain(menuMain.id, menuMain.admin, 'admin')"
                  ></v-checkbox>
                </td>
                <!-- <td>
                  <v-checkbox
                    v-model="menuMain.cashier"
                    @change="
                      changeMain(menuMain.id, menuMain.cashier, 'cashier')
                    "
                  ></v-checkbox>
                </td>
                <td>
                  <v-checkbox
                    v-model="menuMain.waitress"
                    @change="
                      changeMain(menuMain.id, menuMain.waitress, 'waitress')
                    "
                  ></v-checkbox>
                </td>
                <td>
                  <v-checkbox
                    v-model="menuMain.kitchen"
                    @change="
                      changeMain(menuMain.id, menuMain.kitchen, 'kitchen')
                    "
                  ></v-checkbox>
                </td> -->
                <td>
                  <v-checkbox
                    v-model="menuMain.customer"
                    @change="
                      changeMain(menuMain.id, menuMain.customer, 'customer')
                    "
                  ></v-checkbox>
                </td>
              </tr>
              <tr v-for="menu_sub in menuMain.menu_subs_all" :key="menu_sub.id">
                <td>{{ menu_sub.title }}</td>
                <td>
                  <v-checkbox
                    v-model="menu_sub.admin"
                    @change="changeSub(menu_sub.id, menu_sub.admin, 'admin')"
                    :disabled="menuMain.admin == false"
                  ></v-checkbox>
                </td>
                <!-- <td>
                  <v-checkbox
                    v-model="menu_sub.cashier"
                    @change="
                      changeSub(menu_sub.id, menu_sub.cashier, 'cashier')
                    "
                    :disabled="menuMain.cashier == false"
                  ></v-checkbox>
                </td>

                <td>
                  <v-checkbox
                    v-model="menu_sub.waitress"
                    @change="
                      changeSub(menu_sub.id, menu_sub.waitress, 'waitress')
                    "
                    :disabled="menuMain.waitress == false"
                  ></v-checkbox>
                </td>

                <td>
                  <v-checkbox
                    v-model="menu_sub.kitchen"
                    @change="
                      changeSub(menu_sub.id, menu_sub.kitchen, 'kitchen')
                    "
                    :disabled="menuMain.kitchen == false"
                  ></v-checkbox>
                </td> -->

                <td>
                  <v-checkbox
                    v-model="menu_sub.customer"
                    @change="
                      changeSub(menu_sub.id, menu_sub.customer, 'customer')
                    "
                    :disabled="menuMain.customer == false"
                  ></v-checkbox>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import addMenuMain from "@/js/components/shabuNoonee/menuBar/main/add";
import addMenusSub from "@/js/components/shabuNoonee/menuBar/sub/add";
import { mapGetters } from "vuex";

export default {
  components: {
    addMenuMain,
    addMenusSub
  },
  data() {
    return {};
  },
  methods: {
    async changeSub(id, value, key) {
      const res = await this.$store.dispatch("menuBar/changeSub", {
        id,
        value,
        key,
      });

      if (res.status !== 200) {
        this.$toast.error("ระบบทำงานไม่สำเร็จ !");
      }
    },

    async changeMain(id, value, key) {
      const res = await this.$store.dispatch("menuBar/changeMain", {
        id,
        value,
        key,
      });

      if (res.status !== 200) {
        this.$toast.error("ระบบทำงานไม่สำเร็จ !");
      }
    },
  },
  mounted() {
    this.$store.dispatch("menuBar/all");
  },
  computed: {
    ...mapGetters({ menuMains: "menuBar/all" }),
  },
};
</script>
