<template>
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
        v-for="item in items"
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
          v-for="child in item.items"
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
</template>

<script>
export default {
  props: ["drawer"],
  data() {
    return {
      menus: [{ icon: "home", title: "หน้าแรก", to: "/admin/index" }],
      items: [
        {
          action: "shop",
          items: [
            { title: "สินค้า", to: "/admin/product" },
            { title: "กลุ่มสินค้า", to: "/admin/product/group" },
          ],
          //active: true,
          title: "จัดการสินค้า",
        },
      ],
    };
  },
  methods: {},
};
</script>
