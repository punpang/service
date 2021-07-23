<template>
  <div>
    <h4 class="font-weight-black mb-3">เลือกเตา</h4>
    <addCookingType
      @emitAddCookingType="emitAddCookingType"
      v-if="
        propSumCountCustomer > 0 &&
        propSumCountCustomer / 4 > cookingTypes.length
      "
    ></addCookingType>
    <v-simple-table>
      <tbody>
        <tr v-for="cookingType in cookingTypes" :key="cookingType.key">
          <td class="py-2">
            <h5>{{ cookingType.cookingTypeTitle }}</h5>
            <p
              class="ml-4 mb-1"
              v-for="broth in cookingType.broths"
              :key="broth.key"
            >
              x {{ broth.title }}
            </p>
          </td>
          <td class="py-2 text-right">
            <v-btn fab icon @click="clickRemoveCookingType(cookingType)">
              <v-icon color="error">delete</v-icon>
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-simple-table>

    {{ checkCookingType(cookingTypes.length, propSumCountCustomer) }}
  </div>
</template>

<script>
import addCookingType from "@/js/components/shabuNoonee/diningTable/addTable/cookingType/addCookingType";
export default {
  props: ["propSumCountCustomer"],
  components: {
    addCookingType,
  },
  data() {
    return {
      cookingTypes: [],
    };
  },
  methods: {
    emitAddCookingType(v) {
      this.cookingTypes.push(v);
    },
    clickRemoveCookingType(v) {
      this.cookingTypes.splice(this.cookingTypes.indexOf(v), 1);
    },
    checkCookingType(c, s) {
      const a = c * 4 - 3; // 2 * 4 - 3 = 5
      // 4 < 5
      if (s < a) {
        this.cookingTypes.splice(-1,1);
      }
    },
  },
  mounted() {},
};
</script>