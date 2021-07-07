<template>
  <v-data-table
    :headers="headers"
    :items="items"
    hide-default-footer
    :items-per-page="20"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>กลุ่มสินค้า</v-toolbar-title>
        <v-spacer></v-spacer>
        <addGroupProduct></addGroupProduct>
      </v-toolbar>
    </template>
    <template v-slot:item.name="{ item }">
      {{ item.name }}
    </template>
    <template v-slot:item.status="{ item }">
      <v-switch
        v-model="item.status"
        flat
        @change="switchStatus(item.id, item.status)"
      ></v-switch>
    </template>
    <template v-slot:item.manage="{ item }">
      <updateGroupProduct :item="item"></updateGroupProduct>
    </template>
  </v-data-table>
</template>

<script>
import addGroupProduct from "@/js/components/shabuNoonee/products/groupProducts/add";
import updateGroupProduct from "@/js/components/shabuNoonee/products/groupProducts/update";
import { mapGetters } from "vuex";
export default {
  components: {
    addGroupProduct,
    updateGroupProduct,
  },
  data() {
    return {
      headers: [
        {
          text: "ชื่อกลุ่ม",
          align: "start",
          sortable: false,
          value: "name",
        },
        { text: "สถานะ", value: "status" },
        { text: "การจัดการ", value: "manage" },
      ],
    };
  },
  methods: {
    async switchStatus(id, status) {
      const res = await this.$store.dispatch("productGroup/switchStatus", {
        id,
        status,
      });
      if (res.status === 200) {
        this.$toast.success(res.data.message);
      } else {
        this.$toast.error("ระบบทำรายการไม่สำเร็จ");
      }
    },
  },
  computed: {
    ...mapGetters({ items: "productGroup/all" }),
  },
};
</script>