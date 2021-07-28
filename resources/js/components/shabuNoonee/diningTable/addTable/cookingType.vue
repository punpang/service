<template>
  <div>
    <v-row class="px-4 pt-2 mb-1">
      <h4 class="font-weight-black my-1">เลือกเตา</h4>
      <v-spacer></v-spacer>
      <addCookingType
        @emitAddCookingType="emitAddCookingType"
        v-if="
          propSumCountCustomer > 0 &&
          propSumCountCustomer / 4 > propCookingType.length
        "
        :propCookingType="propCookingType"
      ></addCookingType>
    </v-row>

    <v-simple-table>
      <tbody>
        <tr v-for="cookingType in propCookingType" :key="cookingType.key">
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

    {{ checkCookingType(propCookingType.length, propSumCountCustomer) }}
  </div>
</template>

<script>
import addCookingType from "@/js/components/shabuNoonee/diningTable/addTable/cookingType/addCookingType";
export default {
  props: ["propSumCountCustomer", "propCookingType"],
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
      this.propCookingType.push(v);
    },
    clickRemoveCookingType(v) {
      this.propCookingType.splice(this.propCookingType.indexOf(v), 1);
    },
    checkCookingType(c, s) {
      const a = c * 4 - 3; // 2 * 4 - 3 = 5
      // 4 < 5
      if (s < a) {
        this.propCookingType.splice(-1, 1);
      }
    },
  },
  mounted() {},
};
</script>