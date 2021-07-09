<template>
  <v-app>
    <Toolbar :Profile="Profile" @emitDialogNavbar="emitDialogNavbar"></Toolbar>

    <v-navigation-drawer
      app
      v-if="this.$store.getters['main/isLoggedIn'] == true"
      v-model="drawer"
    >
      <v-list class="pb-0">
        <v-list-item link v-for="menu in menus" :key="menu.name" :to="menu.to">
          <v-list-item-icon>
            <v-icon>{{ menu.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ menu.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-list class="pt-0">
        <v-list-group
          v-for="item in menuMain"
          :key="item.title"
          v-model="item.active"
          :prepend-icon="item.action"
          no-action
        >
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title v-text="item.title"></v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item
            v-for="child in item.menu_subs"
            :key="child.title"
            :to="child.to"
          >
            <v-list-item-content>
              <v-list-item-title v-text="child.title"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>

<script>
import Toolbar from "@/js/layouts/Toolbar";
import Navbar from "@/js/layouts/Navbar";
import NavbarAdmin from "@/js/layouts/NavbarAdmin";
import { mapGetters } from "vuex";

export default {
  name: "App",
  components: {
    Toolbar,
    Navbar,
    NavbarAdmin,
  },
  data() {
    return {
      Profile: {},
      drawer: false,
      menus: [{ icon: "home", title: "หน้าแรก", to: "/admin/index" }],
      items: [
        {
          action: "shop",
          title: "จัดการสินค้า",
          items: [
            { title: "สินค้า", to: "/admin/product" },
            { title: "กลุ่มสินค้า", to: "/admin/product/group" },
          ],
          //active: true,
        },
        {
          action: "home",
          title: "แคชเชียร์",
          items: [{ title: "รอปรับปรุง", to: "" }],
        },
        {
          action: "home",
          title: "เสิร์ฟอาหาร",
          items: [{ title: "รอปรับปรุง", to: "" }],
        },
        {
          action: "home",
          title: "ห้องครัว",
          items: [{ title: "รอปรับปรุง", to: "" }],
        },
        {
          action: "home",
          title: "ลูกค้า",
          items: [{ title: "รอปรับปรุง", to: "" }],
        },
        {
          action: "home",
          title: "รายงาน",
          items: [{ title: "รอปรับปรุง", to: "" }],
        },
        {
          action: "home",
          title: "ส่วนตัว",
          items: [{ title: "รอปรับปรุง", to: "" }],
        },
      ],
    };
  },
  methods: {
    emitDialogNavbar() {
      this.drawer = !this.drawer;
    },
  },
  async mounted() {
    await this.$store.dispatch("menuBar/lists");
  },
  computed: {
    ...mapGetters({menuMain : "menuBar/lists"}),
  },
  async beforeCreate() {
    if (localStorage.token) {
      await axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          //this.$store.commit("main/loginUser");
          this.$store.commit("main/User", response.data);
        })
        .catch((error) => {
          if (
            error.response.status == 400 ||
            error.response.status === 401 ||
            error.response.status === 403
          ) {
            this.$store.commit("main/logoutUser");
            localStorage.setItem("token", "");
            this.$router.replace({ name: "login" });
          }
        });
    }
  },
};
</script>

<style>
.v-application {
  font-family: "Sarabun", sans-serif;
}
</style>
