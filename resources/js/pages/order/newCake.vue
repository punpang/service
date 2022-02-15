<template>
  <div>
    <v-btn class="success" @click="submit()">Submit</v-btn>
    {{ form }}
    <v-card class="mb-2">
      <v-card-text>
        <h3>ขนาด</h3>
      </v-card-text>
      <v-card-text>
        <v-radio-group v-model="form.size" row>
          <v-radio
            v-for="size in data.sizes"
            :key="size.id"
            :label="size.title"
            :value="size.id"
            @click="clickSize(size.id)"
          ></v-radio>
        </v-radio-group>
      </v-card-text>
    </v-card>

    <v-card class="mb-2" v-if="form.size">
      <v-card-text>
        <h3>เนื้อเค้ก</h3>
      </v-card-text>
      <v-card-text>
        <v-radio-group v-model="form.cakeTexture" row>
          <v-radio
            v-for="cakeTexture in filter.cakeTextures"
            :key="cakeTexture.id"
            :label="cakeTexture.title"
            :value="cakeTexture.id"
            @click="clickCakeTexture(cakeTexture.id)"
          ></v-radio>
        </v-radio-group>
      </v-card-text>
    </v-card>

    <v-card class="mb-2" v-if="form.cakeTexture">
      <v-card-text>
        <h3>ประเภท</h3>
      </v-card-text>
      <v-card-text>
        <v-radio-group v-model="form.group" row>
          <v-radio
            v-for="group in filter.groups"
            :key="group.id"
            :label="group.title"
            :value="group.id"
          ></v-radio>
        </v-radio-group>
      </v-card-text>
    </v-card>

    <v-card class="mb-2" v-if="form.group && form.size && form.cakeTexture">
      <v-card-text>
        <h3>ตกแต่งสินค้า</h3>
      </v-card-text>
      <v-card-text>
        <v-switch
          label="ขอบบน/ครึ่งหน้า"
          inset
          v-model="options.group1"
          @click="clickOptionGroup1(options.group1)"
        ></v-switch>
        <div v-if="options.group1">
          <v-radio-group row>
            <v-radio
              v-for="group in filter.options.group1"
              :key="group.id"
              :label="group.title"
              :value="group.id"
            ></v-radio>
          </v-radio-group>
          <v-divider></v-divider>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        sizes: [
          { id: 1, title: "1 ปอนด์" },
          { id: 2, title: "2 ปอนด์" },
          { id: 3, title: "3 ปอนด์" },
        ],
        cakeTextures: [
          // 1 ปอนด์
          { id: 1, title: "วานิลลา", sizeID: 1, status: 1 },
          { id: 2, title: "ช็อกโกแล็ต", sizeID: 1, status: 1 },
          // 2 ปอนด์
          { id: 3, title: "วานิลลา", sizeID: 2, status: 1 },
          { id: 4, title: "ช็อกโกแล็ต", sizeID: 2, status: 0 },
          { id: 5, title: "ส้ม", sizeID: 2, status: 1 },
          // 3.ปอนด์
          { id: 6, title: "วานิลลา", sizeID: 3, status: 1 },
          { id: 7, title: "ช็อกโกแล็ต", sizeID: 3, status: 1 },
          { id: 8, title: "ส้ม", sizeID: 3, status: 1 },
        ],
        groups: [
          // 1 ปอนด์ วานิลลา // 1
          { id: 1, title: "ครีมนมสด", cakeTextures: 1, status: 1 },
          // 1 ปอนด์ ช็อกโกแล็ต // 2
          { id: 2, title: "ครีมนมสด", cakeTextures: 2, status: 1 },
          { id: 3, title: "หน้านิ่ม", cakeTextures: 2, status: 1 },
          { id: 4, title: "กานาช", cakeTextures: 2, status: 1 },
          // 2 ปอนด์ วานิลลา // 3
          { id: 5, title: "ครีมนมสด", cakeTextures: 3, status: 1 },
          // 2 ปอนด์ ช็อกโกแล็ต //4
          { id: 6, title: "ครีมนมสด", cakeTextures: 4, status: 1 },
          { id: 7, title: "หน้านิ่ม", cakeTextures: 4, status: 1 },
          { id: 8, title: "กานาช", cakeTextures: 4, status: 1 },
          // 2 ปอนด์ ส้ม //5
          { id: 9, title: "ครีมนมสด", cakeTextures: 5, status: 1 },
          { id: 10, title: "หน้านิ่ม", cakeTextures: 5, status: 1 },
          // 3 ปอนด์ วานิลลา // 6
          { id: 5, title: "ครีมนมสด", cakeTextures: 6, status: 1 },
          // 3 ปอนด์ ช็อกโกแล็ต // 7
          { id: 6, title: "ครีมนมสด", cakeTextures: 7, status: 1 },
          { id: 7, title: "หน้านิ่ม", cakeTextures: 7, status: 1 },
          { id: 8, title: "กานาช", cakeTextures: 7, status: 1 },
          // 3 ปอนด์ ส้ม // 8
          { id: 9, title: "ครีมนมสด", cakeTextures: 8, status: 1 },
          { id: 10, title: "หน้านิ่ม", cakeTextures: 8, status: 1 },
        ],
        options: [
          { id: 1, title: "ขอบบน", group: 1 },
          { id: 2, title: "ครึ่งหน้า", group: 1 },
          { id: 3, title: "ตรงกลาง", group: 2 },
          { id: 4, title: "สอดไส้", group: 3 },
          { id: 5, title: "ขอบข้าง", group: 4 },
        ],
      },
      form: {
        size: "",
        cakeTexture: "",
        group: "",
      },
      filter: {
        cakeTextures: [],
        groups: [],
        options: {
          group1: "",
        },
      },
      options: {
        group1: false,
      },
    };
  },
  methods: {
    clickSize(sizeID) {
      this.form.cakeTexture = "";
      const cakeTexture = this.data.cakeTextures;
      this.filter.cakeTextures = cakeTexture.filter(
        (e) => e.sizeID == sizeID && e.status == 1
      );
    },
    clickCakeTexture(CakeTextureID) {
      this.form.group = "";
      const groups = this.data.groups;
      this.filter.groups = groups.filter(
        (e) => e.cakeTextures == CakeTextureID && e.status == 1
      );
    },
    clickOptionGroup1(boolean) {
      if (boolean === true) {
        const options = this.data.options;
        this.filter.options.group1 = options.filter((e) => e.group == 1);
      }
    },
  },
};
</script>
