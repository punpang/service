<template>
  <div>
    <v-card
      class="mb-3"
      v-for="cookingType in propCookingType"
      :key="cookingType.key"
    >
      <v-card-text>
        <v-row>
          <v-col cols="8" sm="8" class="pb-1">
            <h4 class="mb-0 black--text">
              {{ cookingType.type_cooking.title }}
            </h4>
          </v-col>
          <v-col cols="4" sm="4" class="text-right pb-1">
            <cancelCookingDetail
              :propCookingType="cookingType"
            ></cancelCookingDetail>
          </v-col>
        </v-row>

        <v-row v-for="(broth, index) in cookingType.broth_details" :key="index">
          <v-col cols="12" sm="8" class="pl-8 pt-0 pb-1">
            x {{ broth.product.title }}
          </v-col>
        </v-row>
        <v-divider></v-divider>

        <!-- <v-row>
          <v-col cols="6" class="py-0 mt-1 mb-0">
            <strong>รับรายการ</strong>
          </v-col>
          <v-col cols="6" class="py-0 mt-1 mb-0 text-right">{{
            cookingType.created_at
          }}</v-col>
        </v-row> -->

        <v-row>
          <!-- v-if="
            (cookingType.waitress_user &&
              cookingType.waitress_user.user_id > 0) ||
            !cookingType.status_use
          " -->
          <v-col cols="6" class="py-0 mt-1 mb-0">
            <strong>ทำรายการล่าสุด</strong>
          </v-col>
          <v-col cols="6" class="py-0 mt-1 mb-0 text-right">{{
            cookingType.updated_at
          }}</v-col>
        </v-row>
        <v-row
          v-if="cookingType.waitress_user && cookingType.waitress_user.id_user"
        >
          <v-col cols="6" class="py-0 mt-1 mb-0">
            <strong>ชื่อพนักงาน</strong>
          </v-col>
          <v-col cols="6" class="py-0 mt-1 mb-0 text-right">{{
            cookingType.waitress_user.id_user.name
          }}</v-col>
        </v-row>
        <v-row>
          <v-col cols="7" sm="8" class="py-0 mt-1 mb-1">
            <strong>สถานะ</strong>
          </v-col>
          <v-col cols="5" sm="4" class="py-0 mt-1 mb-1 text-right"
            ><v-btn
              x-small
              block
              :class="cookingType.status_step_detail_cooking.cssClass"
              v-if="cookingType.status_use"
            >
              <p class="pa-0 ma-0">
                {{ cookingType.status_step_detail_cooking.title }}
              </p>
            </v-btn>
            <v-btn x-small block class="error" v-else>
              <p class="pa-0 ma-0">ยกเลิกรายการ</p>
            </v-btn></v-col
          >
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import cancelCookingDetail from "@/js/components/shabuNoonee/diningTable/addTable/cookingType/cancelCookingDetail";
export default {
  props: ["propCookingType"],
  components: {
    cancelCookingDetail,
  },
  data() {
    return {
      clickCancelCookingDetail(id) {
        console.log(id);
      },
    };
  },
};
</script>