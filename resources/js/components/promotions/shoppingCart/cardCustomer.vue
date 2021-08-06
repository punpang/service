<template>
  <div>
    <v-card class="mb-4">
      <v-card-title>
        <h4 class="mb-0">ข้อมูลผู้สั่งซื้อ</h4>
      </v-card-title>
      <v-card-text class="pb-0">
        <v-text-field
          label="ชื่อลูกค้า"
          outlined
          v-model="propCustomer.name"
          :rules="rules.name"
        ></v-text-field>
        <v-text-field
          label="เบอร์โทรศัพท์"
          outlined
          v-model="propCustomer.phone_number"
          :rules="rules.phone_number"
          pattern="\d*"
        ></v-text-field>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["propCustomer"],
  data() {
    return {
      rules: {
        name: [(v) => !!v || "ห้ามเว้นว่าง"],
        phone_number: [
          (v) => !!v || "ห้ามเว้นว่าง",
          (v) => v.length == 10 || "กรอกเบอร์โทร 10 หลักเท่านั้น",
          (v) => {
            const pattern = /[0]{1}[0-9]{9}/;
            return (
              pattern.test(v) ||
              "กรุณาขึ้นต้นด้วยเลข 0 และกรอกเบอร์โทร 10 หลักเท่านั้น"
            );
          },
        ],
      },
    };
  },
};
</script>